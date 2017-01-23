<?php

namespace App\Providers;

use App\Http\Controllers\CommentController;
use App\Navigation\Factory;
use App\Observers\PageObserver;
use App\Repositories\CommentRepository;
use App\Repositories\EventRepository;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use App\Services\CommentsManagerService;
use App\Services\GridService;
use App\Services\MediaService;
use App\Services\PagesService;
use App\Services\SocialAccountService;
use App\Subscribers\CommandSubscriber;
use App\Subscribers\NavigationSubscriber;
use Illuminate\Support\ServiceProvider;
use App\Services\CategoriesService;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupBlade();

        $this->setupListeners();

        Validator::extend('ids_array', function ($attribute, $value, $parameters) {
            $requestArray = unserialize($parameters[0]);
            $model = unserialize($parameters[1]);

            $modelData = $model::all();
            $modelData = $modelData->pluck('id')->toArray();

            if (!is_array($requestArray)) {
                return false;
            }

            return count($requestArray) === count(array_intersect($requestArray, $modelData));
        });

        Validator::replacer('ids_array', function ($message) {
            return str_replace($message, 'Some or all pages you entered don\'t exists!', $message);
        });
    }

    /**
     * Setup the blade compiler class.
     *
     * @return void
     */
    protected function setupBlade()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $this->app['view']->share('__navtype', 'default');

        $blade->directive('navtype', function ($expression) {
            return "<?php \$__navtype = {$expression}; ?>";
        });

        $blade->directive('navigation', function () {
            return '<?php echo \App\Facades\NavigationFactory::make($__navtype); ?>';
        });
    }

    /**
     * Setup the event listeners.
     *
     * @return void
     */
    protected function setupListeners()
    {
        $this->app['events']->subscribe($this->app->make(CommandSubscriber::class));

        $this->app['events']->subscribe($this->app->make(NavigationSubscriber::class));

        $this->app['pagerepository']->observe($this->app->make(PageObserver::class));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerNavigationFactory();

        $this->registerCommentRepository();
        $this->registerEventRepository();
        $this->registerPageRepository();
        $this->registerPostRepository();

        $this->registerCommandSubscriber();
        $this->registerNavigationSubscriber();

        $this->registerCommentController();
        $this->registerCategoriesService();
        $this->registerPagesService();
        $this->registerMediaService();
        $this->registerCommentsManagerService();
        $this->registerGridService();

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Register the social account service class.
     *
     * @return void
     */
    protected function registerSocialAccountService()
    {
        $this->app->bind(SocialAccountService::class, function () {
            return new SocialAccountService();
        });

        $this->app->alias('socialuser', SocialAccountService::class);
    }

    /**
     * Register the social account service class.
     *
     * @return void
     */
    protected function registerGridService()
    {
        $this->app->bind(GridService::class, function () {
            return new GridService();
        });
    }

    /**
     * Register comments manager service.
     *
     * @return void
     */
    protected function registerCommentsManagerService()
    {
        $this->app->bind(CommentsManagerService::class, function () {
            return new CommentsManagerService();
        });
    }

    /**
     * Register the navigation factory class.
     *
     * @return void
     */
    protected function registerNavigationFactory()
    {
        $this->app->singleton('navfactory', function ($app) {
            $credentials = $app['credentials'];
            $navigation = $app['navigation'];
            $name = $app['config']['app.name'];
            $property = $app['config']['cms.nav'];
            $inverse = $app['config']['theme.inverse'];

            return new Factory($credentials, $navigation, $name, $property, $inverse);
        });

        $this->app->alias('navfactory', Factory::class);
    }

    /**
     * Register the comment repository class.
     *
     * @return void
     */
    protected function registerCommentRepository()
    {
        $this->app->singleton('commentrepository', function ($app) {
            $model = $app['config']['cms.comment'];
            $comment = new $model();

            $validator = $app['validator'];

            return new CommentRepository($comment, $validator);
        });

        $this->app->alias('commentrepository', CommentRepository::class);
    }

    /**
     * Register category service.
     *
     * @return void
     */
    protected function registerCategoriesService()
    {
        $this->app->bind(CategoriesService::class, function ($app) {
            return new CategoriesService($app->make(GridService::class));
        });
    }

    /**
     * Register pages service.
     *
     * @return void
     */
    protected function registerPagesService()
    {
        $this->app->bind(PagesService::class, function ($app) {
            return new PagesService($app->make(GridService::class));
        });
    }

    /**
     * Register media service.
     *
     * @return void
     */
    protected function registerMediaService()
    {
        $this->app->bind(MediaService::class, function ($app) {
            return new MediaService($app->make(GridService::class));
        });
    }

    /**
     * Register the event repository class.
     *
     * @return void
     */
    protected function registerEventRepository()
    {
        $this->app->singleton('eventrepository', function ($app) {
            $model = $app['config']['cms.event'];
            $event = new $model();

            $validator = $app['validator'];

            return new EventRepository($event, $validator);
        });

        $this->app->alias('eventrepository', EventRepository::class);
    }

    /**
     * Register the page repository class.
     *
     * @return void
     */
    protected function registerPageRepository()
    {
        $this->app->singleton('pagerepository', function ($app) {
            $model = $app['config']['cms.page'];
            $page = new $model();

            $validator = $app['validator'];

            return new PageRepository($page, $validator);
        });

        $this->app->alias('pagerepository', PageRepository::class);
    }

    /**
     * Register the post repository class.
     *
     * @return void
     */
    protected function registerPostRepository()
    {
        $this->app->singleton('postrepository', function ($app) {
            $model = $app['config']['cms.post'];
            $post = new $model();

            $validator = $app['validator'];

            return new PostRepository($post, $validator);
        });

        $this->app->alias('postrepository', PostRepository::class);
    }

    /**
     * Register the command subscriber class.
     *
     * @return void
     */
    protected function registerCommandSubscriber()
    {
        $this->app->singleton(CommandSubscriber::class, function ($app) {
            $pagerepository = $app['pagerepository'];

            return new CommandSubscriber($pagerepository);
        });
    }

    /**
     * Register the navigation subscriber class.
     *
     * @return void
     */
    protected function registerNavigationSubscriber()
    {
        $this->app->singleton(NavigationSubscriber::class, function ($app) {
            $navigation = $app['navigation'];
            $credentials = $app['credentials'];
            $pagerepository = $app['pagerepository'];
            $blogging = $app['config']['cms.blogging'];
            $events = $app['config']['cms.events'];
            $cloudflare = class_exists('GrahamCampbell\CloudFlare\CloudFlareServiceProvider');

            return new NavigationSubscriber(
                $navigation,
                $credentials,
                $pagerepository,
                $blogging,
                $events,
                $cloudflare
            );
        });
    }

    /**
     * Register the comment controller class.
     *
     * @return void
     */
    protected function registerCommentController()
    {
        $this->app->bind(CommentController::class, function ($app) {
            $throttler = $app['throttle']->get($app['request'], 1, 10);

            return new CommentController($throttler);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'navfactory',
            'commentrepository',
            'eventrepository',
            'fileprovider',
            'folderprovider',
            'pagerepository',
            'postrepository',
            'socialuser'
        ];
    }
}
