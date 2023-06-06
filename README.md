<p align="center">IO</p>

## About IO

Inventory Organizer System

[DB Schema](https://dbdesigner.page.link/XDCe6mDJfkDnMMZ89)


## Installation for developers

### With Docker

Build and run Docker
```bash
# Build project
docker compose build

# Start Docker
docker compose up
```

Install composer packages (run inside `php` docker container)
```bash
composer install

php artisan migrate --seed
```

Install npm packages and start development server
```bash
# Start and connect to node container
docker compose run node sh

npm install
npm run watch
```

### Without Docker

- Download files
- Add domain **io.de** to hosts and apache vhosts file and route it to "**you project folder**/public"
- Create DB: io
- Put .env file in project folder
- Run in project folder command: composer install
- Run in project folder command: npm install
- Run in project folder command: php artisan migrate --seed
- Run in project folder command: npm run watch
- Open in browser io.de
- Log in with oa.edu.ua email

## Developers

- Ihor Zubenko
- Maksym Lutsiuk
- Nataliia Mosiichuk
- Oleksandra Kravets

## Sponsors

-

## Contributing

- 

## Security Vulnerabilities

If you discover a security vulnerability within project, please send an e-mail to ITHub via [ithub@oa.edu.ua](mailto:ithub@oa.edu.ua). All security vulnerabilities will be promptly addressed.

## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
