<?php

namespace System\Enums;


/**
 * Class UserType
 * WARNING: HIGH RISK. Any rash change can destroy system work and unsafely
*/
final class UserType{
    /**
     * Undefined user
     */
    const Undefined=-1;
    /**
     * Default system user
     */
    const User=100;
    /**
     * Edits materials
     */
    const Editor=333;
    /**
     * Observes assessment reports
     */
    const Observer=666;
    /**
     * Manages system configurations
     */
    const Manager=999;
    /**
     * System
     */
    const System=1001;
}