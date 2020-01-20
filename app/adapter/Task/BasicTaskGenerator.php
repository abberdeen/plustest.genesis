<?php

namespace Adapter\Task;

use Adapter\Material\Material;
use Adapter\MaterialSourceFormat\MSFCols;
use Adapter\Discipline\Discipline;
use Adapter\Discipline\DisciplineExt;
use Adapter\ControlMechanism\ControlMechanismSubRule;
use \AppException;
/**
 * Class BasicTaskGenerator
 * First version of PG task generator
 */
class BasicTaskGenerator
{
    /**
     * Generates list of task
     * @param $connection
     * @param Discipline $discipline
     * @param $CMRuleList
     * @return array
     * @throws AppException
     */
    public static function generateList(&$connection, Discipline $discipline, $CMRuleList){
        $taskList = [];
        $disciplineExt = new DisciplineExt($connection, $discipline->getId());
        /** @var ControlMechanismRule $rule */
        foreach ($CMRuleList as $rule){
            $materialList = $disciplineExt->getMaterialsByTaskType($rule->getTaskType());

            /** @var Material $material */
            foreach ($materialList as $material) {
                if ($material->getSource()->getPath() == null || !$material->sourceExists()) {
                    throw new  AppException('Material source table not exists. MaterialId: ' . $material->getId() . '; Source path (database.table): ' . $material->getSource()->getPath(), 2102);
                }
                self::checkColumnExisting($connection,$material);
            }

            /** @var ControlMechanismSubRule $subrule */
            foreach ($rule->getSubrules() as $subrule){

                $subruleTaskCount = $subrule->getTaskCount();
                $subruleTheme=$subrule->getTheme();
                $subruleLevelInTheme=$subrule->getLevelInTheme();

                if($subruleTaskCount<=0){
                    continue;
                }

                $queryRes=null;

                if ($subruleTheme == 0 || $subruleLevelInTheme == -1) {

                    $matStatQuery = self::prepareMatStatQuery($materialList,$subruleTheme,$subruleLevelInTheme);

                    if ($matStatQuery !== '') {

                        $matStat = $connection->Query($matStatQuery);

                        $sum = 0;
                        for ($i = 0; $i < count($matStat); $i++) {
                            $sum += $matStat[$i]['total'];
                        }
                        if ($sum < $subruleTaskCount) {
                            throw new AppException('Material source task count less than sub-rule task count. Material: [id=>[' . self::implodeMaterialId($materialList) . '], query res taskCount=>' . $sum . ']; Subrule: [id=>' . $subrule->getId() . ', taskCount=>' . $subruleTaskCount . '];', 2103);
                        }

                        self::allocateTask($matStat, $subruleTaskCount);

                        $taskSelectQueryByMatStat=self::prepareTaskSelectQueryByMatStat($materialList,$matStat);

                        if ($taskSelectQueryByMatStat !== '') {
                            $queryRes = $connection->Query($taskSelectQueryByMatStat);
                        }
                    }
                }
                else{

                    $taskSelectQuery=self::prepareTaskSelectQuery($materialList,$subruleTheme,$subruleLevelInTheme,$subruleTaskCount);

                    if ($taskSelectQuery !== '') {

                        $queryRes = $connection->Query($taskSelectQuery);

                        if (count($queryRes) < $subruleTaskCount) {
                            throw new AppException('Material source task count less than sub-rule task count. Material: [id=>[' . self::implodeMaterialId($materialList) . '], query res taskCount=>' . count($queryRes) . ']; Subrule: [id=>' . $subrule->getId() . ', taskCount=>' . $subruleTaskCount . '];', 2103);
                        }

                    }

                }

                if(isset($queryRes) AND count($queryRes)>0){
                    foreach ($queryRes as $r) {
                        $taskList[] = [
                            'mat_id' => $r['mat_id'],
                            'task_id' => $r['task_id'],
                            'task_theme' =>$r['theme']
                        ];
                    }
                }
            }
        }
        return $taskList;
    }

    /**
     * @param $connection
     * @param Discipline $discipline
     * @param ControlMechanismSubRule $CMSubRule
     * @param $exceptTaskList
     * @return array
     * @throws AppException
     */
    public static function generateListByLevel(&$connection,Discipline $discipline,ControlMechanismSubRule $CMSubRule,$exceptTaskList=[]){
        $taskList = [];
        $disciplineExt = new DisciplineExt($connection, $discipline->getId());
        /** @var ControlMechanismRule $rule */
        $rule=$CMSubRule->getControlMechanismRule();
        $materialList = $disciplineExt->getMaterialsByTaskType($rule->getTaskType());

        /** @var Material $material */
        foreach ($materialList as $material) {
            if ($material->getSource()->getPath() == null || !$material->sourceExists()) {
                throw new AppException('Material source table not exists. MaterialId: ' . $material->getId() . '; Source path (database.table): ' . $material->getSource()->getPath(), 2102);
            }
            self::checkColumnExisting($connection,$material);
        }

        $queryRes=null;

        $taskSelectQuery=self::prepareTaskSelectQuery($materialList, $CMSubRule->getTheme(),$CMSubRule->getLevelInTheme(),$CMSubRule->getTaskCount());

        if ($taskSelectQuery !== '') {

            $queryRes = $connection->Query($taskSelectQuery);

            if (count($queryRes) < 1) {
                throw new AppException('Material source task count less than sub-rule task count. Material: [id=>[' . self::implodeMaterialId($materialList) . '], query res taskCount=>' . count($queryRes) . ']; Subrule: [id=>' . $CMSubRule->getId() . ', taskCount=>' . $CMSubRule->getTaskCount() . '];', 2103);
            }

        }

        if(isset($queryRes) AND count($queryRes)>0){
            foreach ($queryRes as $r) {
                $taskList[] = [
                    'mat_id' => $r['mat_id'],
                    'task_id' => $r['task_id'],
                    'task_theme' =>$r['theme']
                ];
            }
        }
        return $taskList;
    }

    /**
     * @param $connection
     * @param Material $material
     * @return void
     */
    private static function checkColumnExisting(&$connection,Material &$material){
        $r=$connection->Query("SHOW COLUMNS FROM ".$material->getSource()->getPath()." WHERE FIELD IN('".$material->getSource()->colRank."','".$material->getSource()->colFrequency."');");
        if(count($r)<2){
            $connection->Execute("ALTER TABLE ".$material->getSource()->getPath()."
                                                      ADD COLUMN `".$material->getSource()->colRank."` FLOAT(0) DEFAULT -1 NULL,
                                                      ADD COLUMN `".$material->getSource()->colFrequency."` INT(6) UNSIGNED DEFAULT 0  NULL AFTER `".$material->getSource()->colRank."`;");
        }
    }

    /**
     * Makes sql query for select task list wi11th defined params condition
     * @param Material $material
     * @param MSFCols $cols
     * @return string
     */
    private static function makeQuery(Material &$material,MSFCols $cols, $theme, $level){

        $conditions = "";

        if ($theme > 0) {
            $conditions .= '`' . $cols->theme . '`=' . $theme;
        }

        if ($level >= 0) {
            if ($conditions !== '') {
                $conditions .= ' AND ';
            }
            $conditions .= '`' . $cols->level . '`=' . $level;
        }

        if (isset($material->getSource()->conditions)) {
            if ($conditions !== '') {
                $conditions .= ' AND ';
            }
            $conditions .= $material->getSource()->conditions;
        }

        if(substr_count($cols->id,'(')<=0){
            $cols->id='`'.$cols->id.'`';
        }

        return "SELECT '" . $material->getId() . "' mat_id, " . $cols->id . " task_id, IFNULL(".$material->getSource()->colRank.", -1) rank, IFNULL(".$material->getSource()->colFrequency.", 0) frequency,`" . $cols->theme . "` theme
                FROM " . $material->getSource()->getPath() . " mat ". ($conditions !== '' ? ' WHERE ' . $conditions : '');
    }

    /**
     * @param $materialList
     * @return string
     */
    private static function implodeMaterialId(&$materialList){
        $r = "";
        $c = 0;

        /**@var Material $material */
        foreach ($materialList as $material) {
            $c++;
            if ($c > 1) $r .= ",";
            $r .= $material->getId();
        }
        return $r;
    }

    /**
     * @param $matStat
     * value example:
     * $matStat=[
     *      [
     *          'theme'=>theme,
     *          'level'=>level,
     *          'total'=>total,
     *          'counter'=>counter
     *      ]
     * ];
     * @param $totalTaskCount
     */
    private static function allocateTask(&$matStat, $totalTaskCount){
        $counterTaskCount = 0;
        while ($counterTaskCount < $totalTaskCount) {
            for ($i = 0; $i < count($matStat); $i++){
                if ($matStat[$i]['counter'] < $matStat[$i]['total']) {
                    $matStat[$i]['counter']++;
                    $counterTaskCount++;
                }
                if ($counterTaskCount == $totalTaskCount) break;
            }
        }
    }

    /**
     * @param $materialList
     * @param $theme
     * @param $level
     * @return string
     */
    private static function prepareMatStatQuery(&$materialList,$theme, $level){
        $matStatQuery = "";
        $c = 0;

        /**@var Material $material */
        foreach ($materialList as $material) {
            $cols = $material->getSourceFormatQuery()->getColsByTaskType($material->getTaskType());

            $conditions="";
            if ($theme > 0) {
                $conditions .= '`' . $cols->theme . '`=' . $theme;
            }

            if ($level >= 0) {
                if ($conditions !== '') {
                    $conditions .= ' AND ';
                }
                $conditions .= '`' . $cols->level . '`=' . $level;
            }

            if ($conditions !== '') {
                $conditions  = ' WHERE '.$conditions;
            }

            $c++;
            if ($c > 1) $matStatQuery .= " UNION ALL ";
            $cols = $material->getSourceFormatQuery()->getColsByTaskType($material->getTaskType());
            $matStatQuery .= " SELECT " . $cols->theme . " theme," . $cols->level . " `level` FROM " . $material->getSource()->getPath()."  ".$conditions;
        }

        if($matStatQuery !== '') {
            $matStatQuery = "SELECT `theme`,`level`,COUNT(*) `total`,0 counter
                             FROM (".$matStatQuery.") q
                             GROUP BY `theme`,`level`
                             ORDER BY `theme`,`level`;";
        }
        return $matStatQuery;
    }

    /**
     * @param $materialList
     * @param $theme
     * @param $level
     * @param $taskCount
     * @return string
     */
    private static function prepareTaskSelectQuery(&$materialList,$theme,$level,$taskCount){
        $q = "";
        $counter = 0;

        /** @var Material $material */
        foreach ($materialList as $material) {
            $counter++;
            $cols = $material->getSourceFormatQuery()->getColsByTaskType($material->getTaskType());
            if ($counter > 1) {
                $q .= " UNION ALL \n";
            }
            $q .= self::makeQuery($material, $cols, $theme, $level);
        }
        if ($q !== '') {

            $q .= " ORDER BY `frequency` ASC, `rank` ASC
                              LIMIT " . $taskCount . " ";
        }
        return $q;
    }

    /**
     * @param $materialList
     * @param $matStat
     * @return string
     */
    private static function prepareTaskSelectQueryByMatStat(&$materialList,&$matStat){
        $counter = 0;
        $query = "";
        for ($i = 0; $i < count($matStat); $i++) {
            if($matStat[$i]['counter']<=0){
                continue;
            }
            $taskSelectQuery=self::prepareTaskSelectQuery($materialList,$matStat[$i]['theme'],$matStat[$i]['level'],$matStat[$i]['counter']);
            if ($taskSelectQuery !== '') {
                $counter++;
                if ($counter > 1) {
                    $query .= " UNION ALL \n";
                }
                $query .= "SELECT * FROM (" . $taskSelectQuery . ") q".$i." ";
            }
        }
        return $query;
    }
}







 