====================
Trivago\\Tas\\Config
====================

The :code:`Trivago\Tas\Config` service contains the configuration of the :code:`Trivago\Tas\Tas` service.

.. _reference_config_options:

Configuration options
=====================

In this chapter you will find all configuration options. The code below summarizes all options that are available.

.. code-block:: php

    use Trivago\Tas\Config;

    $config = new Config([
        Config::ACCEPT_LANGUAGE            => 'en-GB',
        Config::API_KEY                    => 'YOUR API KEY',
        Config::BASE_URL                   => 'https://api.trivago.com/webservice/affiliate',
        Config::GET_TRACKING_ID_CALLBACK   => function () {},
        Config::HTTP_HANDLER               => new \Trivago\Tas\HttpHandler\Curl(),
        Config::STORE_TRACKING_ID_CALLBACK => function ($trackingId) {},
    ]);


Parameters
----------

+----------------------------+----------------+------------+
| Parameter                  | Type           | Required?  |
+============================+================+============+
| ACCEPT_LANGUAGE            | string         | no         |
+----------------------------+----------------+------------+
| API_KEY                    | string         | yes        |
+----------------------------+----------------+------------+
| BASE_URL                   | string         | no         |
+----------------------------+----------------+------------+
| GET_TRACKING_ID_CALLBACK   | callback       | yes        |
+----------------------------+----------------+------------+
| HTTP_HANDLER               | HttpHandler    | no         |
+----------------------------+----------------+------------+
| STORE_TRACKING_ID_CALLBACK | callback       | yes        |
+----------------------------+----------------+------------+


Config::ACCEPT_LANGUAGE
-----------------------

This option allows you to change the output language. The value will be sent in a header and needs to be compatible
to the `Accept-Language` HTTP header. If the accept language does not exist a fallback language is used (in most cases
this will be English).


Config::API_KEY
---------------

Your `API key` to get access to the webservice.


Config::BASE_URL
----------------

The base URL of the webservice. You can change this if needed for example if you want to use the sandbox service for
testing.


Config::GET_TRACKING_ID_CALLBACK
--------------------------------

Callback to retrieve the trivago Tracking ID. This must be a callable that returns the Tracking ID from the user. If
the user does not have a Tracking ID yet, the callable returns :code:`null` instead.


Config::HTTP_HANDLER
--------------------

The default HTTP handler is cURL.
You can write your own HTTP handler by implementing the HttpHandler interface :code:`\Trivago\Tas\HttpHandler\HttpHandler`.


Config::STORE_TRACKING_ID_CALLBACK
----------------------------------

Callback to store the trivago Tracking ID. This must be a callable that is called whenever the Tracking ID is assigned
or changes.
