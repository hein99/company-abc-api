## About the project
This is a simple project to practice API concept.
You can find the 'API_information.pdf' file that explain the business requirements and development scope.

### Documentation and Logic process for each API works
You can find these files in this repo
Documentation => api-documentation.html <br>
Logic of Api works => ABC_Campaign_API_Flowcharts.pdf

### Installation
1. Clone the repo
```sh
git clone https://github.com/hein99/company-abc-api.git
```
2. Install Composer packages
```sh
composer install
```
3. Copy the environment file and edit it accordingly
```sh
cp .env.example .env
```
4. Generate application key
```sh
php artisan key:generate
```
5. Create Database tables and insert dummny data(*Make sure database info in .env)
```sh
php artisan migrate:fresh --seed
```
6. Serve the application
```sh
php artisan serve
```

### Access API
Before using API, you need to go to the following link to get API Access Token
```sh
/setup
```

1. Customer eligible check API
```sh
GET /api/v1/campaign/participate
```
2. Validate photo submission API
```sh
POST /api/v1/campaign/getVoucher
```


