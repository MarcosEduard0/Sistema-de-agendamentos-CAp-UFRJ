# classroombookings Changelog

## [3.1.1] 2021-06-23
### Adicionado
- Validade nas contas de usuário professor, com tempo customizado em meses na pagina de configurações.
- Filtro de busca de usuário pelo seu login, nome ou última conexão

### Alterado
- Paginação de úsuario customizada entre 10, 25, 50 ou 100 usuários por página.
- Visual dos check box para Toggle 
- Alert JS ao deletar um agendamento alterado para um Modal

### Corrigido
- Validação de campo existente ao tentar criar um dado ja existente no banco, agora parecendo uma div com a msg inves de um flash

### Removido
- Obrigatoriedade de o usuário possuir e-mail


## [3.0.0] 2021-06-21
### Adicionado
- Novas opções ao realizar um agendamento
- Nova tela de login
- Novo sistema de mensagem para ao usuário
- Aperfeiçoamento na importação de usuários

### Alterado
- Visual dos labels e verificação de resposta vazia.

## [2.5.0] 2021-04-27

### Adicionado
- Recurso de controle de acesso à sala - defina a visibilidade de cada sala para usuários ou departamentos específicos.

### Alterado
- Dimensionamento atualizado para widget Seletor de data.
- Adicionadas strings de consulta de impedimento de cache a recursos JS / CSS.
- Correção no Calendário escolar, agora o sistema salva ao desmarcar todas as semnas de uma só vez.

### Corrigido
- Problema com o carregamento de entradas de idioma de substituição do banco de dados.

## [2.4.0] 2020-03-10

### Added
- Support for setting a custom message to appear on the login page.
- Support for controlling the visibility of booking user details to other users.

### Changed
- Improvements for back/next navigation between days; will now skip days that don't have any periods.


## [2.3.2] 2020-09-25

### Fixed
- Issue saving school details when an error occurs.


## [2.3.1] 2020-09-25

### Fixed
- Issue when saving school details when an error occurs.


## [2.3.0] 2020-08-26

### Added
- Support for LDAP authentication.
- Support for language line overrides in the database.

### Changed
- General javascript tidy-up and library updates.
- New style of room information popup on Bookings pgae.

### Fixed
- Removed erroneous debugging output from Weeks model.


## [2.2.0] 2020-06-06

### Added
- New settings page for additional settings.
- New setting for 'maximum active bookings': specify how many active bookings a user can have at one time.
- Date and Time display formats on Bookings page can now be customised.
- License details.

### Changed
- Updated icons to better quality PNG format.

### Fixed
- Issue where bookings on Sundays were not being displayed.


## [2.1.3] 2020-03-11

### Fixed
- Fixed another situation where existing bookings were being detected incorrectly.


## [2.1.2] 2019-12-03

### Fixed
- Fixed previous fix for database detection during installation which affected post-install.


## [2.1.1] 2019-12-02

### Fixed
- Fixed issue where Install page wouldn't load/would display errors when trying to load database.


## [2.1.0] 2019-11-13

Introducing the new 'Maintenance Mode' feature.

When enabled, Maintenance Mode prevents Teacher user accounts from viewing and making changes to bookings. The message can be customised, and will be displayed at the top of all pages.


### Added
- Added a new section to the School Details settings page to manage Maintenance Mode.

### Fixed
- Fixed an issue with one of the database migrations that might occur when updating from a pervious version.


## [2.0.5] 2019-09-30

Another update to "existing booking" check and minor tweaks.

### Changed
- Updated "Existing Bookings" check to make sure the Weekday was properly included.
- Updated the 'Recurring' section of the 'Make a booking' page to default the weekday value to the weekday of the chosen date.
- Updated 'Add week' page to have a default contrasting background colour.



## [2.0.4] 2019-08-31

Another update to make the "existing booking" check more robust.

### Changed
- Updated "Existing Bookings" check to make sure the Week was properly included.


## [2.0.3] 2019-08-31

Small update to address a Holiday display issue.

### Changed
- Updated Bookings to display Holiday details, when applicable, instead of an existing static or recurring booking.


## [2.0.2] 2019-06-19

One small bugfix.

### Changed
- Fixed an issue with User and Department lists having default limit applied when they shouldn't.


## [2.0.1] - 2019-01-26

Minor fix to day settings for periods and addition of favicon.

### Added
- Favicon to help classroombookings stand out in tabs and windows.

### Changed
- Fixed an issue relating to possible issues with period days being shifted by one if upgraded from v1 to v2.


## [2.0.0] - 2019-01-02

The big one! Major update to support modern PHP, plus others.

### Added
- PHP Requirement for minimum version 5.5, and support for 7.x.
- Use Composer for dependencies.
- Database migrations.
- New installer.
- New upgrader for v1 => v2.

### Changed
- Updated CodeIgniter framework to version 3.
- Updated all class files for compatibility with CodeIgniter 3.
- Updated folder structure and configuration file methods.
- Security updates for HTML escaping.
- Fixed various bugs.
- Bitmask library for period/lesson time days.

### Removed
- Header image colour generation.
