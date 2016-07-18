===============
Getting started
===============

System Requirements
===================

- PHP 5.6 or greater
- `cURL <http://php.net/manual/en/book.curl.php>`_ extension
- `Composer <https://getcomposer.org>`_ (optional)


Installation
============

There are two ways to install the SDK in your project. We strongly recommend to use Composer. But if you cannot use
Composer in your project you can still install the SDK manually.


Installing with Composer (recommended)
--------------------------------------

The easiest way to install the trivago affiliate SDK for PHP is composer. You can simply add the following to your
"require" entry to the :code:`composer.json` file in the root of your project.

.. code-block:: json

    {
        "require": {
            "trivago/tas-sdk-php": "^1.0"
        }
    }


Installing manually (if needed)
-------------------------------

First `download the trivago affiliate SDK for PHP <https://github.com/trivago/tas-sdk-php/releases>`_ and
unzip the file whereever you like in your project.

Afterwards include the autoloader provided in the SDK at the top of your script.

.. code-block:: php

    require_once __DIR__ . '/relative-path/to/tas-sdk-php/autoload.php'


Configuration and setup
=======================

.. note:: This step assumes that you already received your `Access ID` and your `Secret Key`.

Before you can send requests to our API you have to pass the app configuration to the client.

The first step of configuration is adding your Access ID and Secret Key to the config. This is a mandatory step.

.. code-block:: php

    $tas = new \Trivago\Tas\Tas(new Trivago\Tas\Config([
        Trivago\Tas\Config::ACCESS_ID  => 'YOUR ACCESS ID',
        Trivago\Tas\Config::SECRET_KEY => 'YOUR SECRET KEY',
    ]));

For tracking the user’s searches the API is issuing a so called 'trivago Tracking ID'. This Tracking ID is unique per
user and needs to be added to each request. The simplest way to store the Tracking ID is to use cookies. The two
callback functions are required.

.. code-block:: php

    $tas = new \Trivago\Tas\Tas(new Trivago\Tas\Config([
        Trivago\Tas\Config::ACCESS_ID                  => 'YOUR ACCESS ID',
        Trivago\Tas\Config::SECRET_KEY                 => 'YOUR SECRET KEY',
        Trivago\Tas\Config::GET_TRACKING_ID_CALLBACK   => function () {
            return isset($_COOKIE['trv_tid']) ? $_COOKIE['trv_tid'] : null;
        },
        Trivago\Tas\Config::STORE_TRACKING_ID_CALLBACK => function ($trackingId) {
            setcookie('trv_tid', $trackingId, 2147483647, '/', null, null, true);
        }
    ]));

In the example above the Tracking ID is stored in a cookie. It is stored as long as possible. Depending on your
application framework you might want to use an abstraction layer to store the cookie. You can pass any callable to
the configuration.

See the reference for :code:`Trivago\Tas\Config` to learn more about all :ref:`config options <reference_config_options>`.
