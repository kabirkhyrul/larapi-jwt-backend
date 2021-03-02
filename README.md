
# Laravel 8 API backend with JWT auth

[![GitHub forks](https://img.shields.io/github/forks/kabirkhyrul/larapi-jwt-backend?label=Forks&style=for-the-badge)](https://github.com/kabirkhyrul/larapi-jwt-backend/network) [![GitHub stars](https://img.shields.io/github/stars/kabirkhyrul/larapi-jwt-backend?style=for-the-badge)](https://github.com/kabirkhyrul/larapi-jwt-backend/stargazers)

## WHAT IS JSON WEB TOKEN?
JSON Web Token (JWT) is an open standard (RFC 7519) that defines a compact and self-contained way for securely transmitting information between parties as a JSON object. This information can be verified and trusted because it is digitally signed. JWTs can be signed using a secret (with HMAC algorithm) or a public/private key pair using RSA.

Let’s explain some concepts of this definition further.

### Compact
    Because of its size, it can be sent through an URL, POST parameter, or inside an HTTP header. Additionally, due to its size its transmission is fast.
### Self-contained
    The payload contains all the required information about the user, to avoid querying the database more than once.

JWTs consist of three parts separated by dots (.), which are:

- Header
- Payload
- Signature

Therefore, a JWT typically looks like the following.

`
 xxxxx.yyyyy.zzzzz
`


## Installation
``` bash
# clone repo
git clone https://github.com/kabirkhyrul/larapi-jwt-backend.git 

# enter cloned repo
cd larapi-jwt-backend/

# install composer dependency
composer install

# copy new env 
cp .env.example .env

# add to code editor
code . 

# change db credentials

# generate key that will be used to sign your tokens.
php artisan jwt:secret

# clear and cache config
php artisan config:clear

php artisan config:cache

```

Import postman collection `storage/app/Laravel8 Rest api backend with JWT auth.postman_collection.json`
