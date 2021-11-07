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
- All APIs document are public here: __https://documenter.getpostman.com/view/1752165/UVC3jTRB__
- Import to postman collection via json link: __https://www.getpostman.com/collections/f2b88bff5ec9d2a76a85__
- Import to postman environment via link: __https://go.postman.co/workspace/My-Workspace~b597c852-084e-4a17-80fe-3403c4e18a26/environment/1752165-643ebf85-bda4-4c8f-bfdc-7253b256a2ff__
- Open postman application.
- We need add a __{{API_URL}}__ && __{{TOKEN}}__ variable to Postman environment example: __http://local.aspire.com/api__.
- We have two user roles. (Admin & User)
- Using login API __api/auth/login__ with default credentials __devtesting@gmail.com__ - __123456__ to get user's jwt (Role is "User").
- To approve a loan application, Please login with admin credentials __admin@gmail.com__ - __123456__ (Role in “Admin”) then use __update loan application API__ with param status = "approved".


## License


