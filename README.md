# Laravel mini-aspire APIs

Your task is to build a mini-aspire API:
It is an app that allows authenticated users to go through a loan application. It doesn’t have to contain too many fields, but at least “amount
required” and “loan term.” All the loans will be assumed to have a “weekly” repayment frequency.
After the loan is approved, the user must be able to submit the weekly loan repayments. It can be a simplified repay functionality, which won’t
need to check if the dates are correct but will just set the weekly amount to be repaid.

## How to use and run in local

- Clone this repository 
- Cd to project root and run __chmod u+x ./setup.sh && ./setup.sh__

## How to use APIs
- All API's document are public here : __https://documenter.getpostman.com/view/1752165/UVC3jTRB__
- Open Postman App/Web to use APIs
- We need add a __{{API_URL}}__ variable to Postman environments example: __http://local.aspire.com/api__
- Using API __api/auth/login__ to get Jwt'user Token. And save it to Postman environments (__{{TOKEN}}__ variable)
 
## License


