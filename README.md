# Model Generator

**Model Generator** - Will read your current table structure and generate a model will the filled in fields automatically.

You can generate a single table model, or multiple at once.

**Author(s):**
* [Laracademy](https://laracademy.co) ([@laracademy](http://twitter.com/laracademy), michael@laracademy.co)

## Requirements

1. PHP 5.6+
3. Laravel 5.2+

## Usage

### Step 1: Install through Composer

```
composer require "laracademy/model-generator"
```

### Step 2: Add the Service Provider
The easiest method is to add the following into your `config/app.php` file

```php
Laracademy\ModelGenerator\ModelGeneratorServiceProvider::class
```

Depending on your set up you may want to only use these providers for development, so you don't update your `production` servers. Instead, add the provider in `app/Providers/AppServiceProvider.php' like so

```php
public function register()
{
    if($this->app->environment() == 'local) {
        $this->app->register('Laracademy\ModelGenerator\ModelGeneratorServiceProvider');
    }
```

### Artisan
Now that we have added the generator to our project the last thing to do is run Laravel's Arisan command

```
php artisan
```

You will see the following in the list

```
generate:model
```

## Examples

### Generating a single table

```
php artisan generate:model users
```

## License
ModelGen is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Bug Reporting and Feature Requests
Please add as many details as possible regarding submission of issues and feature requests

### Disclaimer
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.