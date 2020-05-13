# swivel

#this is Swivel test 


# Getting started

## Installation

Clone the repository
git clone https://github.com/kanishkamaduranga/swivel.git 

Switch to the repo folder

nstall all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

## Setup Postman Collection

 "swivel.postman_collection.json" and "swivel-local.postman_environment.json" files are import to post man
 
double check postman evoronment with serve url 
 
 
## Start Testing

- GET Organization
<pre>
 rEQUEST :    curl --location --request GET 'http://127.0.0.1:8001/api/v1/organization?page=3&limit=10'
</pre>
<pre>
RESPONSE :-   {
    "status": 200,
    "description": "OK",
    "data": {
        "current_page": 3,
        "data": {
            "20": {
                "_id": 121,
                "url": "http://initech.tokoin.io.com/api/v2/organizations/121.json",
                "external_id": "3fffbf20-9172-4d1d-923b-f247d9132e3a",
                "name": "Hotcâkes",
                "domain_names": [
                    "recrisys.com",
                    "qiao.com",
                    "makingway.com",
                    "shopabout.com"
                ],
                "created_at": "2016-01-02T06:07:59 -11:00",
                "details": "MegaCorp",
                "shared_tickets": true,
                "tags": [
                    "Howard",
                    "Moreno",
                    "Benton",
                    "Bonner"
                ]
            },
            "21": {
                "_id": 122,
                "url": "http://initech.tokoin.io.com/api/v2/organizations/122.json",
                "external_id": "33c4e38d-bfa3-4b12-9bb6-6f547524cf33",
                "name": "Geekfarm",
                "domain_names": [
                    "comstar.com",
                    "zytrex.com",
                    "austech.com",
                    "enervate.com"
                ],
                "created_at": "2016-04-10T11:12:35 -10:00",
                "details": "Non profit",
                "shared_tickets": true,
                "tags": [
                    "Hensley",
                    "Garza",
                    "Roberts",
                    "Vega"
                ]
            },
            "22": {
                "_id": 123,
                "url": "http://initech.tokoin.io.com/api/v2/organizations/123.json",
                "external_id": "12831719-9173-47c7-8834-fa5b26877393",
                "name": "Terrasys",
                "domain_names": [
                    "isoplex.com",
                    "equicom.com",
                    "premiant.com",
                    "combogen.com"
                ],
                "created_at": "2016-04-23T04:40:09 -10:00",
                "details": "MegaCorp",
                "shared_tickets": true,
                "tags": [
                    "Fisher",
                    "Forbes",
                    "Koch",
                    "Lester"
                ]
            },
            "23": {
                "_id": 124,
                "url": "http://initech.tokoin.io.com/api/v2/organizations/124.json",
                "external_id": "15c21605-cbc6-440f-8da2-6e1601aed5fa",
                "name": "Bitrex",
                "domain_names": [
                    "unisure.com",
                    "boink.com",
                    "quinex.com",
                    "poochies.com"
                ],
                "created_at": "2016-05-11T12:16:15 -10:00",
                "details": "Non profit",
                "shared_tickets": true,
                "tags": [
                    "Lott",
                    "Hunter",
                    "Beasley",
                    "Glass"
                ]
            },
            "24": {
                "_id": 125,
                "url": "http://initech.tokoin.io.com/api/v2/organizations/125.json",
                "external_id": "42a1a845-70cf-40ed-a762-acb27fd606cc",
                "name": "Strezzö",
                "domain_names": [
                    "techtrix.com",
                    "teraprene.com",
                    "corpulse.com",
                    "flotonic.com"
                ],
                "created_at": "2016-02-21T06:11:51 -11:00",
                "details": "MegaCorp",
                "shared_tickets": false,
                "tags": [
                    "Vance",
                    "Ray",
                    "Jacobs",
                    "Frank"
                ]
            }
        },
        "from": 21,
        "to": 25,
        "last_page": 3,
        "pre_page": 10,
        "total": 25
    }
}
</pre>

- GET Users
