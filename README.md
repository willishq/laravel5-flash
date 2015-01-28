Laravel 5 Flash Message Helper
==============================

Inspired by [Laracasts Flash](https://github.com/laracasts/flash)

## Installation

Coming soon...

## Usage

Ideally use within your base controller as so:

```php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Willishq\Flash\Flash;
use Illuminate\View\Factory;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;
	/**
	 * @var Flash
	 */
	protected $flash;
	public function __construct(Factory $view, Flash $flash)
	{
		$this->flash = $flash;
		$view->share('flash', $flash);
	}
}
```

To fire off a flash message:

```php
class FooController extends BaseController {

	public function somethingNeat()
	{
	    // epic codes
	    $this->flash->success('success message');
	    return redirect('/');
	}
}

```
To display flash messages in your view:

```blade
@if($flash->exists())
	@if($flash->isPanel())
		<div class="panel">
			<h5>{{ $flash->title }}</h5>
			<p>{{ $flash->message }}</p>
		</div>
	@else
		<div data-alert class="alert-box {{ $flash->type }}">
			<p>{{ $flash->message }}</p>
			<a href="#" class="close">&times;</a>
		</div>
	@endif

@endif
```
