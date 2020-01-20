<?php if(!function_exists('_acdb550314d9c3b4fdcefdf944709b2b')){header('content-type=text','',404);die();}

/**
 * Application constants
 */
 /*
 * app relative root URL from server URL, path to app index & .htaccess file
 * set value to '' if s`ite located in root path of server
 * path should not have slashes in end
 */
define('APP_ROOT','');
/*
 * app data and components location (it should be this file location) without slashes in start and end
 */
define('APP_PATH','app');
define('APP_FULL_PATH',APP_ROOT.(APP_PATH == '' ? '' : '/').APP_PATH);
define('APP_LAYOUT_PATH',APP_PATH.'/layouts');

//Application info
const APP_AUTHOR="ADM Microsystems Ltd.";
const APP_BRAND="Polytechnic Assessment";
const APP_BRAND_EN="Polytechnic Assessment";
const APP_FULL_NAME="ADM's Legacy";
const APP_ACRONYM="OA";
const APP_COPYRIGHT="© 2016-2018 Plustest™ (compatible with ECTS).
® Polytechnic Assessment.";

/**
 * Session
 */
const SS_USER_TOKEN="84b3d17d89f0a178f04d8a97f8ac0661";
const SS_USER_LOGIN_IP="5fb3c80129b65155e6d5db9a6b94fb6c";
const SS_USER_LOGIN_AGENT="3f3cbf1468b6eb251074c48338646b1f";
const SS_FORM_NAME="38d5a5342501b9b95a4298d694faa056";
const SS_APP_LANG="39c0712feecde141fa840f6700e852e2";
const SS_APP_LANG_EXPIRE="089c562d59e8fd1b7fddcba8ea269e7e";
const SS_EVENT_ID="896dfeec53621596cb87c8b4f8f05ee8";
const SS_ASSESSMENT_ID="70e8221002d37e62259d721e7e594b24";
const SS_FORM_TOKEN="19c3128918ddcd06d04241885e97bd1e";
const SS_ENCRYPTION_KEY="cede4cc2c21afd3dcaca86fc0192bcaa";
/**
 * COOKIE
 */
const CK_APP_LANG="USERLANG";

/**
 * SYSTEM
 */
//ajax view dir name in requests
const AJAX_DIR_NAME='svc';

//boolean: enable or disable debug mode
const DEBUG_MODE_ENABLED=true;

//integer: require captcha when {try count >= value}  (STILL DOESN'T CREATED. You can do it)
const AUTH_CAPTCHA_ON_TRY=5;

//integer: limit of user auth try (count of incorrect password enter) after expire limit user will banned for AUTH_BAN_DURATION
const AUTH_MAX_TRY=8;

//integer: in minutes; cauth bans when user auth try equals to AUTH_MAX_TRY
const AUTH_BAN_DURATION=60;

//integer: DO NOT CHANGE
const USER_TOKEN_LENGTH=32;

//boolean: enable or disable constructor logging when user id is null (user is not logged to system)
const ENABLE_CTR_LOGGING_IFNULL=true;