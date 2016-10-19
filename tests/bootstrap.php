<?php

/*
 * Copyright 2016 trivago GmbH
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once __DIR__ . '/../vendor/autoload.php';

$_bootstrap_function = function () {

    if (getenv('WEB_SERVER_HOST')) {
        // there is an external test server we can run the HttpHandler tests against.
        define('WEB_SERVER_HOST', getenv('WEB_SERVER_HOST'));
        define('WEB_SERVER_PORT', getenv('WEB_SERVER_PORT') ?: '80');

        return;
    }

    if (defined('HHVM_VERSION')) {
        // do not run PHP server in HHVM.
        return;
    }

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        // do not run PHP server on Windows.
        return;
    }

    define('WEB_SERVER_HOST', 'localhost');
    define('WEB_SERVER_PORT', '1234');

    $command = sprintf(
        'php -S %s:%d %s >/dev/null 2>&1 & echo $!',
        WEB_SERVER_HOST,
        WEB_SERVER_PORT,
        __DIR__ . '/server.php'
    );
    echo $command . PHP_EOL;

    $output = [];
    exec($command, $output);
    $pid = (int) $output[0];

    printf(
        '%s - web server started in %s:%d PID %d' . PHP_EOL,
        date('r'),
        WEB_SERVER_HOST,
        WEB_SERVER_PORT,
        $pid
    );

    register_shutdown_function(function () use ($pid) {
        printf('%s - killing web server with PID %d', date('r'), $pid);
        echo PHP_EOL;
        exec('kill ' . $pid);
    });

};

$_bootstrap_function();
