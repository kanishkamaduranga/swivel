# swivel

# this is Swivel test 


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
 REQUEST :    curl --location --request GET 'http://127.0.0.1:8001/api/v1/organization?page=3&limit=10'
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
            .............................
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
<pre>
REQUEST :-    curl --location --request GET 'http://127.0.0.1:8001/api/v1/user?page=3&limit=10'
</pre>
<pre>
RESPONSE :- 
"status": 200,
    "description": "OK",
    "data": {
        "current_page": 3,
        "data": {
            "20": {
                "_id": 21,
                "url": "http://initech.tokoin.io.com/api/v2/users/21.json",
                "external_id": "b4524a24-212a-4ce5-ba6b-c488b72a3ad5",
                "name": "Leon Oneil",
                "alias": "Miss Dee",
                "created_at": "2016-03-01T03:12:09 -11:00",
                "active": true,
                "verified": false,
                "shared": true,
                "locale": "de-CH",
                "timezone": "Bosnia and Herzegovina",
                "last_login_at": "2014-12-10T06:19:41 -11:00",
                "email": "deeoneil@flotonic.com",
                "phone": "9314-713-633",
                "signature": "Don't Worry Be Happy!",
                "organization_id": 110,
                "tags": [
                    "Faxon",
                    "Bellfountain",
                    "Gracey",
                    "Muir"
                ],
                "suspended": false,
                "role": "admin"
            },
            
            .................................
        },
        "from": 21,
        "to": 30,
        "last_page": 8,
        "pre_page": 10,
        "total": 75
    }
}
</pre>

- GET Tickets
<pre>
REQUEST :-     curl --location --request GET 'http://127.0.0.1:8001/api/v1/ticket?page=10&limit=10'
</pre>
<pre>
RESPONSE :-  

{
    "status": 200,
    "description": "OK",
    "data": {
        "current_page": 10,
        "data": {
            "90": {
                "_id": "6e77bbf1-5fc7-4f41-aeb1-74f8730f974b",
                "url": "http://initech.tokoin.io.com/api/v2/tickets/6e77bbf1-5fc7-4f41-aeb1-74f8730f974b.json",
                "external_id": "3ce8b7f5-952b-485a-a6c3-8d5259d3850a",
                "created_at": "2016-06-24T07:57:38 -10:00",
                "type": "problem",
                "subject": "A Problem in Guatemala",
                "description": "Ex labore dolor commodo magna ex pariatur sunt amet ad quis duis laborum. Fugiat anim non esse eu sunt elit.",
                "priority": "high",
                "status": "open",
                "submitter_id": 49,
                "assignee_id": 26,
                "organization_id": 119,
                "tags": [
                    "Texas",
                    "Nevada",
                    "Oregon",
                    "Arizona"
                ],
                "has_incidents": true,
                "due_at": "2016-08-01T11:20:58 -10:00",
                "via": "voice"
            },
            
            .................................................
        },
        "from": 91,
        "to": 100,
        "last_page": 20,
        "pre_page": 10,
        "total": 200
    }
}
</pre>

-- POST Search 

<pre>
    ### paramiters 
</pre>
    ----"type" must be { organization , ticket, user},
    ----"field"= is existing field and "any"  for search in all fields",
    ----"keyword" is search key , it can de empty
<pre>
 REQUEST :- curl --location --request POST 'http://127.0.0.1:8001/api/v1/search?type=ticket&field=tags&keyword=Nevada' 
</pre>

<pre>
RESPONSE :-
status": 200,
    "description": "OK",
    "data": {
        "87db32c5-76a3-4069-954c-7d59c6c21de0": {
            "_id": "87db32c5-76a3-4069-954c-7d59c6c21de0",
            "url": "http://initech.tokoin.io.com/api/v2/tickets/87db32c5-76a3-4069-954c-7d59c6c21de0.json",
            "external_id": "1c61056c-a5ad-478a-9fd6-38889c3cd728",
            "created_at": "2016-07-06T11:16:50 -10:00",
            "type": "problem",
            "subject": "A Problem in Morocco",
            "description": "Sit culpa non magna anim. Ea velit qui nostrud eiusmod laboris dolor adipisicing quis deserunt elit amet.",
            "priority": "urgent",
            "status": "solved",
            "submitter_id": 14,
            "assignee_id": 7,
            "organization_id": 118,
            "tags": [
                "Texas",
                "Nevada",
                "Oregon",
                "Arizona"
            ],
            "has_incidents": true,
            "due_at": "2016-08-19T07:40:17 -10:00",
            "via": "voice",
            "organization_name": "Limozen",
            "submitter_name": "Shepherd Joseph",
            "assignee_name": "Lou Schmidt"
        },
        "fc5a8a70-3814-4b17-a6e9-583936fca909": {
            "_id": "fc5a8a70-3814-4b17-a6e9-583936fca909",
            "url": "http://initech.tokoin.io.com/api/v2/tickets/fc5a8a70-3814-4b17-a6e9-583936fca909.json",
            "external_id": "e8cab26b-f3b9-4016-875c-b0d9a258761b",
            "created_at": "2016-07-08T07:57:15 -10:00",
            "type": "problem",
            "subject": "A Nuisance in Kiribati",
            "description": "Ipsum reprehenderit non ea officia labore aute. Qui sit aliquip ipsum nostrud anim qui pariatur ut anim aliqua non aliqua.",
            "priority": "high",
            "status": "open",
            "submitter_id": 1,
            "assignee_id": 19,
            "organization_id": 120,
            "tags": [
                "Minnesota",
                "New Jersey",
                "Texas",
                "Nevada"
            ],
            "has_incidents": true,
            "via": "voice",
            "organization_name": "Andershun",
            "submitter_name": "Francisca Rasmussen",
            "assignee_name": "Francis Rodrigüez"
        },
        .......................
        
        }}
</pre>

