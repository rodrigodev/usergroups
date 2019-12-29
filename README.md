# User Groups

## General
### Requirements
- docker
- docker-compose

### Installation

`$ make build`

### Running

`$ make run`

### How to use

**authentication**:
```
curl -X POST "http://127.0.0.1/api/authenticate" \
    -H "accept: application/json" \
    -H "Content-Type: application/json" \ 
    -d "{ \"username\": \"admin\", \"password\": \"admin\"}"
```

**authentication response**:
```
{
  "success": true,
  "token": "595c694b7f5192a035d1d67844f1d22d"
}
```
Use the returned token to make additional requests, like the following:

**Get horses list**:
```
curl -X GET "http://127.0.0.1/api/horses" \ 
    -H "accept: application/json" \
    -H "X-AUTH-TOKEN: 595c694b7f5192a035d1d67844f1d22d"
```

**You can also use swagger api documentation bellow**
### Api Documentation

http://localhost/api/doc

## Additional commands
### Running Tests
- Get the container id with `$ docker ps`
- Run `$ docker exec -it {container_id} make test`

running test erases the database and load fixtures

### Running Fixtures
- Get the container id with `$ docker ps`
- Run `$ docker exec -it {container_id} make fixtures`

