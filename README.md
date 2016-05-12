# Better Model Generator (ModelGen)

**ModelGen** - Will read your current table structure and generate a model will the filled in fields automatically

`ModelGen` is a command that will quickly generate a model for you based on your current table scheme found in your database.

You can generate a single table model, or multiple at once.

**Author(s):**
* [Laracademy](https://laracademy.co) ([@laracademy](http://twitter.com/laracademy), michael@laracademy.co)

## Requirements

1. PHP 5.6+
3. Laravel 5.2+

### Composer
Start a new Laravel project:
```php
composer create-project laravel/laravel your-project-name
```

Then run the following to add ModelGen
```php
composer require "laracademy/modelgen"
```

### Providers
Add this to the `bootsrap/app.php` in the service providers array:
```php
Laracademy\ModelGen\ModelGenProvider::class
```

## Commands
The console commands provided by ModelGen are as follows:

### model
----
The model command will take a single or multiple tables as an option. The command will then generate the models based on those tables as they are found in your database.

```php
php artisan modelgen:table --table=users
```

## License
ModelGen is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Bug Reporting and Feature Requests
Please add as many details as possible regarding submission of issues and feature requests

### Disclaimer
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
