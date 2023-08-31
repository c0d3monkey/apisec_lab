# apisec_lab
fork to add authentiation and authorization using JWT

This a continuation of the api nef work done by Alex.

This branch adds security to the APIs : Authentication & Authorization.

For this purpose, we used JWT standard  and token formatting to implement the API Authentication and Authorization Security.

For this JWT, we used firebase jwt library available for php / py..


Client API Security Flow:
------------------
+ customer will first  authenticate, and gets also a JWT token.
  <img width="547" alt="image" src="https://github.com/abdessamad-elamrani/apisec_lab/assets/29716902/08f02779-f523-46d5-b138-64bce96ad7b6">


+ This token can be added to http authorization and used to access to the right services, in this case, customer is adding a new subscriber , notice the appended token in the auth header:
  <img width="673" alt="image" src="https://github.com/abdessamad-elamrani/apisec_lab/assets/29716902/7f628dea-d025-4738-ba0e-9e36e63b02af">

Code changes highlights:
------------------------
+ added a **login.php**  file code, this will be the entry point and used to authenticate the users, this code handles incoming auth api, connects to DB, check login/password,
  if successful, generate and returns a jwt valid token (for 3600 sec, this can be changed) 
+ Updated **Subscriber.php** to only honor an API request if it has a Token and if the Token is valid, the new code will extract jwt from the bearer header, decode it (base64),
 compare the claims (customerid,..), and extract the hash, and recalculate and compare if same to validate the authorization.
+ Note that same update yet to be done to other API entry point (**delete.php**, **read.php**,..)
+ Updated the SQL nef DB , added a password column that we will use for authentication (Along with customername already existing in the table)
**sql> ALTER TABLE customer ADD password VARCHAR(255);**
note: you can update current customers password:
**sql> UPDATE customer SET password = 'new_password_here' WHERE id = 1;**
  
Futur enhancements suggetions:
------------------------------
+ store password as hash instead of plain text for better security
+ implement https instead of http for the api for better security
+ avoid hard coding the KID (keyid) and KeySecret in the code, use external party.
+ implement rotation of keys



  
