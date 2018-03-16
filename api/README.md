KODI WEB API
============

This is the API of KODI web application.
The Api is commonly related with different KODI applications launched on mobile and kiosk devices.  
  The concept of authentication to the API is following:  
  1. A user has to log in using their login/password directly on remote (mobile or kiosk) application (in case of kiosk app it happens automatically).  
  2. The API server obtains login/password credentials, checks them in DB and generates unique access token alongside with refresh token which has more long live time (the time is determined by server configuration).  
  3. Now the application can operate with the API server using that access token.
  4. In order to log actions from particular device, it must have it's own unique id. In mobile applications we get it using [react-native-device-info] package. In native kiosk app we get it with `sudo cat /sys/class/dmi/id/product_uuid` command.  
  While user (on mobile app) or program (on kiosk app) authenticates on API server, they send their unique device id alongside with email/password credentials. If the device doesn't exist it will be automatically created. Then every major actions, made by the device, will be registered.  
  
The Api also support multilingual responses (English and Italian currently supported).  
To get response with particular language, you have to set **Content-Language** header with specific language (en or it).  
If the header is not set, the user's default language will be used. If it's a guest, the system default language (English) will be used.
  
  
Supported Endpoints:
--------------------
Auth
----
  
- **POST /auth/sign-in**  
Signs user in by issuing an access token  
Request `POST /auth/sign-in`:  
```
{
    "email": "some-email@example.com",
    "password": "some_password",
    "uuid": "unique_devie_id",
    "type": "device_type", // Mobile or Kiosk or Browser
    "name": "device_name" // Optional
}
```  
Response:  
```
{
    "success": true,
    "data": {
        "user": {
            "info": {
                "id": 1,
                "user_id": 1,
                "name": "Admin",
                "surname": null,
                "photo": null,
                "country": null,
                "city": null,
                "state": null,
                "address": null,
                "postcode": null,
                "location_latitude": null,
                "location_longitude": null
            },
            "settings": {
                "component_facebook_email": "webmaster@meetkodi.com",
                "component_facebook_password": "12345678",
                "service_api_allow_requests": "1",
                "content_search_min_symbols": "2",
                "device_watermark_photo": "http://backend.meetkodi.com/img/uploads/device_watermark_photo.png",
                "device_countries_support": "Italy,Poland,Russia,Turkey,Ukraine,United Kingdom",
                "users_max_prints_amount": "1",
                "users_language": "en"
            }
        },
        "session": {
            "id": 17,
            "token": "YJiHAnBj61__5C14EJxfnIJdVQ1G97G3",
            "token_refresh": "pqohbWvs4B6YSo8qVVoSwroH0RHe2WF4",
            "expires_in": 3600
        }
    }
}
```

- **POST /auth/sign-up**  
Signs user up.  
Note. Unlike sign-in method, this one is for users who use third party apps not for devices  
Devices are registering automatically with sign-in method  
Request `POST /auth/sign-up`:  
```
{
    "name": "Full User Name", // Optional
    "email": "some-email@example.com",
    "password": "some_password",
    "info": { // Optional
        "latitude": "52.1256",
        "longitude": "49.2549"
    },
    "settings": { // Optional
        "users_language": "it"
    }
}
```   
Response:  
```
{
    "success": true,
    "data": "New user account is successfully created. Please confirm your email address."
}
```

- **POST /auth/sign-out**  
Signs user out.  
Request `POST /auth/sign-out`:  
```
{
    "id": "24",
    "token": "pXV8OjIhUX-CouEVIpmMJ6zIbi69tnyk"
}
```  
Response:  
```
{
    "success": true,
    "data": true
}
```

- **POST /auth/token-refresh**  
Refreshes token.  
Request `POST /auth/token-refresh`:  
```
{
    "id": "25",
    "token": "_mOGvGgPG8o6Ap2SO-hOe-EKHOM4uDC_" // Note, refresh token here
}
```  
Response:  
```
{
    "success": true,
    "data": {
        "user": {
            "info": {
                "id": 1,
                "user_id": 1,
                "name": "Admin",
                "surname": null,
                "photo": null,
                "country": null,
                "city": null,
                "state": null,
                "address": null,
                "postcode": null,
                "location_latitude": null,
                "location_longitude": null
            },
            "settings": {
                "component_facebook_email": "webmaster@meetkodi.com",
                "component_facebook_password": "12345678",
                "service_api_allow_requests": "1",
                "content_search_min_symbols": "2",
                "device_watermark_photo": "http://backend.meetkodi.com/img/uploads/device_watermark_photo.png",
                "device_countries_support": "Italy,Poland,Russia,Turkey,Ukraine,United Kingdom",
                "users_max_prints_amount": "1",
                "users_language": "en"
            }
        },
        "session": {
            "id": 25,
            "token": "TreYqW4kirSb1L7r-MJgp6ZT2Sxf5Qx1",
            "token_refresh": "Z1zb-ORy7dTetml-WZLUa-s4fp8kOXKN",
            "expires_in": 3600
        }
    }
}
```

- **POST /auth/password-reset**  
Request `POST /auth/password-reset`:  
```
{
    "email": "Footniko@gmail.com"
}
```  
Response:  
```
{
    "success": true,
    "data": "We sent instructions to your email address."
}
```
 
 
 [//]: # (These are reference links used in the body of this document)
 
 [react-native-device-info]: <https://github.com/rebeccahughes/react-native-device-info>
