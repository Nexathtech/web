KODI Yii2 Application
=====================

This is the KODI web application.

API
---
The Api is commonly related with different KODI applications launched on mobile and kiosk devices.  
The concept of authentication to the API is following:  
1. A user has to log in using their login/password directly on remote (mobile or kiosk) application (in case of kiosk app it happens automatically).  
2. The API server obtains login/password credentials, checks them in DB and generates unique access token alongside with refresh token which has more long live time (the time is determined by server configuration).  
3. Now the application can operate with the API server using that access token.
4. In order to log actions from particular device, it must have it's own unique id. In mobile applications we get it using [react-native-device-info] package. In native kiosk app we get it with `sudo cat /sys/class/dmi/id/product_uuid` command.  
While user (on mobile app) or program (on kiosk app) authenticates on API server, they send their unique device id alongside with email/password credentials. If the device doesn't exist it will be automatically created. Then every major actions, made by the device, will be registered.
 
 
 [//]: # (These are reference links used in the body of this document)
 
 [react-native-device-info]: <https://github.com/rebeccahughes/react-native-device-info>
