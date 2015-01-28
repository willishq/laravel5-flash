<?php namespace Willishq\Flash;

use Illuminate\Session\Store;
use Illuminate\View\Factory;
/**
 * Laravel 5 Flash messages inspired by Laracasts Flash Messages.
 *
 * @link https://github.com/laracasts/flash
 *
 * @author Andrew Willis <andrew@willishq.co.uk>
 *
 */
class Flash {
	/**
	 * @var string
	 */
	public $message;
	/**
	 * @var string
	 */
	public $title;
	/**
	 * @var string
	 */
	public $type;
	/**
	 * @var Store
	 */
	protected $session;
	/**
	 * @var string
	 */
	protected $namespace = 'willishq_flash';
	/**
	 * @var bool
	 */
	protected $exists = false;

	public function __construct(Store $session, Factory $view) {
		$this->session = $session;
		$view->share('flash', $this);
		if ($this->session->has($this->namespace)) {
			$flashed  = $this->session->get($this->namespace);
			$this->message = $flashed['message'];
			$this->title = $flashed['title'];
			$this->type = $flashed['type'];
			$this->exists = true;

		}
	}
	/**
	 * Determine whether flash data exists on this request.
 	 * @return bool
	 */
	public function exists()
	{
		return $this->exists;
	}


	/**
	 * Setup the flash messsage data.
	 *
	 * @param string $message
	 * @param string $title
	 * @param string $level
	 */
	protected function message($message, $title = '', $type = 'info')
	{
		$this->message = $message;
		$this->title = $title;
		$this->type = $type;
		$this->session->flash($this->namespace, (array) $this);
	}

	/**
	 * Magic method to create error messages from type or check if a message is a type.
	 *
	 * <code>
	 * $flash->error('error message', 'title');
 	 * $flash->success('success message', 'title');
	 * $flash->overlay('message', 'title');
	 *
	 * $flash->isError(); // bool
	 * $flash->isPanel(); // bool
	 * $flash->isOverlay(); //bool
	 * </code>
	 *
	 * @param string $type
	 * @param array $params
	 */
	public function __call($type, $params)
	{
		if (count($params) === 0 && strpos($type, 'is') === 0) {
			$type = strtolower(str_replace('is', '', $type));
			return $this->type === $type;
		} else if (count($params) === 1) {
			$this->message($params[0], '', $type);
		} else if (count($params) === 2) {
			$this->message($params[0], $params[1], $type);
		}
	}
}
