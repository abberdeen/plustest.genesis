<?php

namespace System\Enums;



final class AuthenticationState{
    /**
     * @const UNDEFINED
     */
    const UNDEFINED=0;
    /**
     * @const SUCCESS
     * When auth successful
     */
    const SUCCESS=1;
    /**
     * @const BROKED_TOKEN
     * token broked
     */
    const BROKED_TOKEN=2;
    /**
     * @const NOT_HAVE_IP_ACCESS
     */
    const NOT_HAVE_IP_ACCESS=3;
    /**
     * @const AUTHORIZATION_ERR
     */
    const AUTHORIZATION_ERR=4;
    /**
     * @const TOKEN_FAIL
     */
    const TOKEN_FAIL=5;
    /**
     * @const AUTH_TIMEOUT
     */
    const AUTH_TIMEOUT=6;
    /**
     * @const USER_LOGIN_IP_ERR
     */
    const USER_LOGIN_IP_ERR=7;
    /**
     * @const INCORRECT_USERNAME
     */
    const INCORRECT_USERNAME=8;
    /**
     * @const INCORRECT_PASSWORD
     */
    const INCORRECT_PASSWORD=9;
    /**
     * @const EMPTY_USERNAME
     */
    const EMPTY_USERNAME=10;
    /**
     * @const EMPTY_PASSWORD
     */
    const EMPTY_PASSWORD=11;
    /**
     * @const USER_LOGIN_AGENT_ERR
     */
    const USER_LOGIN_AGENT_ERR=12;
    /**
     * @const IP BANNED
     */
    const IP_BANNED=13;
}