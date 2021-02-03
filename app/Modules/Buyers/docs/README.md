# Buyer API DOCS

# Base URL
http://localhost

# Other resources 

 
# Headers

Authorization: key your token

Accept : application/json

# API 

| Route                        | Request Method | Parameters | Response  |
| -----------                  | -----------    |----------- |---------- |
| /api/admin/buyers            | POST           |  [Create Parmaters](#Create)|[Response](#Response)|
| /api/admin/buyers | GET           |-|  [Response](#Response)         |
|/api/admin/buyers/{id}         | GET           |  - |  [Response](#Response)         |
|/api/admin/buyers/{id}        |PUT           |  [Update Parmaters](#Update)|[Response](#Response)     |
|/api/admin/buyers/{id}        |DELETE           |  -|[Response](#Response)| 
|/api/buyers        |GET           |-| [Response](#Response)|
|/api/buyers/{id}        |GET           |-|[Response](#Response)|


# <a name="Create"> </a> Create new Buyer 

```json
{
"firstName" : "String"
"lastName" : "String"
"email" : "String"
"password" : "String"
"mobile" : "String"
"mobileIsVerified" : "Bool"
} 
```

# <a name="Update"> </a> Update Buyer

```json
{
"firstName" : "String"
"lastName" : "String"
"email" : "String"
"password" : "String"
"mobile" : "String"
"mobileIsVerified" : "Bool"
} 
```
# <a name="Response"> </a> Responses 

## Unauthorized error

__*Response code : 401*__
```json 
{
    "message" : "Unauthenticated"
}
```

## Validation error 
__*Response code : 422*__

```json 
{
    "errors" {
        "Key" : "Error message"
    }
}
```
## Success  
__*Response code : 200*__
```json 
{
    "records" [
        {

        },
    ]
}
```
