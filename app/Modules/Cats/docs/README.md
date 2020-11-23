# Cat API DOCS

# Base URL
http://localhost

# Other resources 

 
# Headers

Authorization: key your token

Accept : application/json

# API 

| Route                        | Request Method | Parameters | Response  |
| -----------                  | -----------    |----------- |---------- |
| /api/admin/cats            | POST           |  [Create Parmaters](#Create)|[Response](#Response)|
| /api/admin/cats | GET           |-|  [Response](#Response)         |
|/api/admin/cats/{id}         | GET           |  - |  [Response](#Response)         |
|/api/admin/cats/{id}        |PUT           |  [Update Parmaters](#Update)|[Response](#Response)     |
|/api/admin/cats/{id}        |DELETE           |  -|[Response](#Response)| 
|/api/cats        |GET           |-| [Response](#Response)|
|/api/cats/{id}        |GET           |-|[Response](#Response)|


# <a name="Create"> </a> Create new Cat 

```json
{
"name" : "String"
"order" : "Int"
} 
```

# <a name="Update"> </a> Update Cat

```json
{
"name" : "String"
"order" : "Int"
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
