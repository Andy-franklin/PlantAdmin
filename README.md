#### This project is not ready for use

# Historical Data for Plant Management Admin Panel

![Image of a chilli pepper](public/images/chilli.svg)

An admin interface allowing for plant tracking, crossbreeding, QR code labelling,
note taking and more.

### Setup

##### Installing dependencies

`composer install`

`npm install`

##### Building javascript

Development: `npm run dev`

Production: `npm run prod`

##### Database

Create a mysql database and set this in `.env`

##### File uploads

Enable user uploaded images to be shown using `php artisan storage:link`

### Planned Features

- [ ] New plant form
    - [ ] Species and Variety
    - [ ] CrossBreeding:
        * Validation of non-viable crosses
        * Parent plants
    - [ ] Generations:
        * Filial generation tracking
    - [ ] Status:
        * What stage is the plant at?
            - Germinated
            - Potted
            - etc

- [ ] Plant QR code
    - [ ] Label generator
    - [ ] Print ready label generator (Multiple per a4 page)
    - [ ] QR Scanner
        - [ ] Plant history page
            - [ ] Family tree
            - [ ] Notes
            - [ ] Uploaded pictures
        - [ ] Guest page
            - [ ] WYSIWYG editor for guest viewing
            - [ ] Ability to hide notes + images from guest view
        - [ ] Admin page
            - [ ] Full history
            - [ ] Location data
            - [ ] Environmental data
            
