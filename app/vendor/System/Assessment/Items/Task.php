<?php
namespace System\Assessment\Items;


use System\Object;
use System\Enums\DataFormat;

/**
 * Class Task
 */
abstract class Task extends Object{

    /**
     * @param string $id
     * @param int $type
     */
    public function __construct($id,$type){
        $this->id=$id;
        $this->type=$type;
    }

    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $text
     */
    private $text;
    public function  getText(){
        return $this->text;
    }
    public function  setText($text){
        $this->text=$text;
    }

    /**
     * @var
     */
    public $dataFormat=DataFormat::HTML;

    /**
     * multiple choice/multiple response/numeric etc
     * @var TaskType $taskType
     */
    public $type;

    /**
     * expected to take in seconds.
     * @var
     */
    public $timeLimit;

    /**
     * subject
     * @var
     */
    public $theme;

    /**
     * introductory/intermediate etc - in Scottish FE it would be appropriate to use SCQF levels
     * @var
     */
    public $level;

    /**
     * threshold students/good students/excellent students
     * @var
     */
    public $discrimination;

    /**
     * knowledge/understanding/application/analysis/synthesis/evaluation
     * @var
     */
    public $cognitiveLevel;

    /**
     * formative/summative/formative or summative/diagnostic
     * @var
     */
    public $style;

    /**
     * what part of that subject
     * @var
     */
    public $subThemes;

    /**
     * what other themes might find this question useful
     * @var
     */
    public $relatedThemes;

    /**
     * text for use by people browsing the database
     * @var
     */
    public $description;

    /**
     * for use by people searching the database
     * @var
     */
    public $keywords;

    /**
     * confirmation that the question has been validated (moderated)
     * @var
     */
    public $validation;

    /**
     * @var
     */
    public $peerReviewDate;

    /**
     * who reviewed it
     * @var
     */
    public $reviewers;

    /**
     * @var
     */
    public $comments;

    /**
     * @return mixed
     */
    public function __toString(){
        return $this->pre("Task Object(
&t&t[Id] => ".$this->id."
&t&t[Text] => ".htmlspecialchars($this->text)."
&t&t[DataFormat] => ".$this->dataFormat."
&t&t[TaskType => ".$this->type."
&t&t[Theme] => ".$this->theme."
&t&t[Level] => ".$this->level."
&t&t[TimeLimit] => ".$this->timeLimit."
&t&t[Description] => ".$this->description."
&t)");
    }

}