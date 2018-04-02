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
  
The Api also supports multilingual responses (English and Italian currently supported).  
To get response with particular language, you have to set **Content-Language** header with specific language (en or it).  
If the header is not set, the user's default language will be used. If it's a guest, the system default language (English) will be used.
  
  
Supported Endpoints:
--------------------

Site
----

- **/site/settings**  
Retrieves global settings. Every setting has its access level. For guests there will be no sensible settings.
It's also possible to retrieve some bunch related settings.  
Request `GET|POST /site/settings`  
Response:  
```
{
    "success": true,
    "data": {
        "service_api_allow_requests": "1",
        "content_search_min_symbols": "2",
        "device_watermark_photo": "http://backend.meetkodi.com/img/uploads/device_watermark_photo.png",
        "device_countries_support": [
            "Italy",
            "Poland",
            "Russia",
            "Turkey",
            "Ukraine",
            "United Kingdom"
        ],
        "mobile_app_orders_allowed": true,
        "users_max_prints_amount": "1",
        "languages_support": {
            "en": "English",
            "it": "Italian"
        }
    }
}
```

- **/site/waiting-list**  
Adds specified email to waiting list.  
Request `POST /site/waiting-list`:  
```
{
    "email": "Footniko@gmail.com"
}
```  
Response:  
```
{
    "success": true,
    "data": {
        "message": "Thank you! The email Footniko@gmail.com was successfully added to the Waiting list"
    }
}
```


Auth
----
  
- **/auth/sign-in**  
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
                "service_api_allow_requests": "1",
                "content_search_min_symbols": "2",
                "device_watermark_photo": "http://backend.meetkodi.com/img/uploads/device_watermark_photo.png",
                "device_countries_support": "Italy,Poland,Russia,Turkey,Ukraine,United Kingdom",
                "mobile_app_orders_allowed": "1000",
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

- **/auth/sign-up**  
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

- **/auth/sign-out**  
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

- **/auth/token-refresh**  
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
                "service_api_allow_requests": "1",
                "content_search_min_symbols": "2",
                "device_watermark_photo": "http://backend.meetkodi.com/img/uploads/device_watermark_photo.png",
                "device_countries_support": "Italy,Poland,Russia,Turkey,Ukraine,United Kingdom",
                "mobile_app_orders_allowed": "1000",
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

- **/auth/password-reset**  
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


Account
-------
- **/account/save-profile**  
Request `POST /account/save-profile`:  
```
{
    "city": "Lviv",
    "settings": {
        "users_language": "it"
    }
}
```  
Response:  
```
{
    "success": true,
    "data": {
        "info": {
            "id": 1,
            "user_id": 1,
            "name": "Admin",
            "surname": "",
            "photo": null,
            "country": "",
            "city": "Lviv",
            "state": "",
            "address": "",
            "postcode": "",
            "location_latitude": null,
            "location_longitude": null
        },
        "settings": {
            "users_language": "it"
        }
    }
}
```

- **/account/upload-images**

- **/account/change-type**  
Request for changing users type.  
Request `POST /account/change-type`:  
```
{
    "type": "Brand" // could be Simple or Brand
}
```
Response:  
```
{
    "success": true,
    "data": "The request is successfully sent. We will consider it asap."
}
```


Action
------
Controller that handles major actions made by third-parties apps like mobile app or kiosk app.  

- **/action/register**
Request `POST /action/register`:  
```
{
    "action_type": "PrintShipment", // Could be Print, PrintShipment or Feedback
    "data": { // Non-strict data
    	"shipping": {
    		"name": "Test",
    		"surname": "Testio",
    		"address": "Clioh 678",
    		"postcode": "6788-43",
    		"city": "Milan",
    		"state": null,
    		"country": "Denmark"
    	},
    	"images": {
    		"i_1731879342130575146" :{
    			"id": "i_1731879342130575146",
    			"path": "https://scontent-arn2-1.cdninstagram.com/vp/785d6c7e6c771cd04c100b9efd810a20/5B0550A9/t51.2885-15/e35/17932150_317639751986970_6853141527934271488_n.jpg",
    			"count": 1,
    			"dimensions": {
    				"width": 654.54545454545,
    				"height": 1080
    			},
    			"type": "image/jpeg",
    			"isLocal": true
    		}
    	}
    }
}
```  
Response:  
```
{
    "success": true,
    "data": {
        "action_type": "PrintShipment",
        "data": "{\"shipping\":{\"name\":\"Test\",\"surname\":\"Testio\",\"address\":\"Clioh 678\",\"postcode\":\"6788-43\",\"city\":\"Milan\",\"state\":null,\"country\":\"Denmark\"},\"images\":{\"i_1731879342130575146\":{\"id\":\"i_1731879342130575146\",\"path\":\"https://scontent-arn2-1.cdninstagram.com/vp/785d6c7e6c771cd04c100b9efd810a20/5B0550A9/t51.2885-15/e35/17932150_317639751986970_6853141527934271488_n.jpg\",\"count\":1,\"dimensions\":{\"width\":654.54545454545,\"height\":1080},\"type\":\"image/jpeg\",\"isLocal\":true}}}",
        "user_id": 1,
        "status": "New",
        "device_id": 1,
        "device_type": "Kiosk",
        "created_at": "2018-03-16 15:45:06",
        "id": 5
    }
}
```


Promo Code
----------
Handles promo codes.  
- **/promo-code/create**  
Creates random promo code.  
Request `POST /promo-code/create`:  
```
{
    "description": "This is a test promocode" // Optional
}
```  
Response:  
```
{
    "success": true,
    "data": {
        "code": 66764,
        "description": "This is a test promocode",
        "expires_at": "2018-03-17 15:53:59",
        "created_at": "2018-03-16 15:53:59",
        "id": 1
    }
}
```

- **/promo-code/use**
Request `GET /promo-code/use/{promo_code}`:  
Response:  
```
{
    "success": true,
    "data": {
        "id": 1,
        "code": "66764",
        "identity_id": null,
        "description": "This is a test promocode",
        "status": "Used",
        "created_at": "2018-03-16 15:53:59",
        "expires_at": "2018-03-17 15:53:59"
    }
}
```

 
 [//]: # (These are reference links used in the body of this document)
 
 [react-native-device-info]: <https://github.com/rebeccahughes/react-native-device-info>
