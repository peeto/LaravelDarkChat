# LaravelDarkChat
## For using DarkChat in Laravel 5

In composer.json update the following:

```
    "require": {
        "peeto/dark-chat": ">=0.95"
    },
```

In app/Http/Middleware/VerifyCsrfToken.php add the following (depending on your routes/controllers):

```
    protected $except = [
        '/chat',
        '/chatxml'
    ];
```

Add the following controller app/Controllers/ChatController.php:

```
use peeto\DarkChat;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class ChatController extends Controller {

    protected $config;
    
    public function setConfig($config) {
        $this->config = $config;
    }
    
    protected function load() {
        DarkChat\Chat::load([
            'config' => $this->config,
            'route' => 'chat',
            'xml_message_route' => 'chatxml',
            'xml_send_message_route' => 'chatxml'
        ]);
    }
    
    protected function getOutput() {
        ob_start();
        $this->load();
        return ob_get_clean();
    }
    
    public function showChat($config) {
        $this->config = $config;
        $data = $this->getOutput();
        return view('chat', ['data'  => $data]);
    }

    public function showXmlChat($config) {
        $this->config = $config;
        $data = $this->getOutput();
        return response()->view('chatxml', ['data'  => $data])->header('Content-Type', 'text/xml');
    }

}
```

Add to routes.web.php:

```
/* ChatController */
Route::get('chat', function() {
    $chatcontroller = new App\Http\Controllers\ChatController();
    return $chatcontroller->showChat(Storage::disk('local')->path('chatconfig.php'));
});
Route::get('chatxml', function() {
    $chatcontroller = new App\Http\Controllers\ChatController();
    return $chatcontroller->showXmlChat(Storage::disk('local')->path('chatconfig.php'));
});
Route::post('chatxml', function() {
    $chatcontroller = new App\Http\Controllers\ChatController();
    return $chatcontroller->showXmlChat(Storage::disk('local')->path('chatconfig.php'));
});
```

Add the following views to resources/views/:

chat.blade.php:

```
<div>
    <h2>Chat</h2>
    <br />
</div>

{!! $data !!}
```
and chatxml.blade.php:

```
{!! $data !!}
```

_Note: No other markup should be present in chatxml.blade.php as it is XML only however chat.blade.php can be treated like any other view._

From here you can style it with CSS and customise roues/controllers to your liking
