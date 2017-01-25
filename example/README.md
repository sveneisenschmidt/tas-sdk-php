# Example Application

This is an example application.

## Get Started

### 1. Update config

Before you can start using our SDK you have to request credentials to
authenticate against the tAS webservice.

After you received your API Key you can copy
`config.php.example` to `config.php` and adjust it accordingly.

### 2. Start web server

#### 2.1 Build build in PHP Server

First you need to change your working directory to this example folder.
Ensure to replace the path with the path on your machine.

```
cd ~/development/tas-sdk-php/example
```

Then you can start the build in PHP server with the following command.

```
php -S 0.0.0.0:8080 -t ./web
```

You can now open the example in your browser: [http://localhost:8080](http://localhost:8080).

#### 2.2 Docker

First you need to change your working directory to this example folder.
Ensure to replace the path with the path on your machine.

```
cd ~/development/tas-sdk-php/example
```

Now start a web server using the following docker command.

```
docker run -v $(pwd)/..:/var/www/html -p 8080:80 php:apache
```

You can now open the example in your browser: [https://localhost:8080/example/web/](https://localhost:8080/example/web/)

If you are using you have to replace `localhost` with the IP address of your virtual machine
or open your browser via the command line `open http://$(docker-machine ip):8080/example/web`.

## FAQ

### Problems with cURL on Windows

I am getting this error with cURL `Uncaught RuntimeException: SSL certificate problem: unable to get local issuer certificate`, what can I do?

1. Download the CA certificates from https://curl.haxx.se/ca/cacert.pem
2. Save to local folder e.g. `C:/xampp/cacert.pem`
3. Edit php.ini and add or change in section `[curl]` the following line:
```
[curl]
curl.cainfo="C:/xampp/cacert.pem
```
4. Restart web server
