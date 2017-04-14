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
use App\Services\PostService;
use App\Services\GridService;
use App\Services\MediaService;
use App\Services\PagesService;
use App\Services\SocialAccountService;
use App\Subscribers\CommandSubscriber;
use App\Subscribers\NavigationSubscriber;
use Illuminate\Support\ServiceProvider;
use App\Services\CategoriesService;
use App\Services\ConfigurationsService;
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

        Validator::extend('name_unique', function ($attribute, $value, $parameters) {
            $configService = new ConfigurationsService();
            $environments = $configService->getEnvironmentsList();

            return !in_array($parameters[0], $environments);
        });

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

        Validator::replacer('name_unique', function ($message) {
            return str_replace($message, 'Config with such name already exists!', $message);
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
        $this->registerConfigurationsService();
        $this->registerMediaService();
        $this->registerCommentsManagerService();
        $this->registerPostService();
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

        $this->app->alias('socialuser', 'App\Services\SocialAccountService');
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
     * Register comments manager service.
     *
     * @return void
     */
    protected function registerPostService()
    {
        $this->app->bind(PostService::class, function () {
            return new PostService();
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

        $this->app->alias('navfactory', 'App\Navigation\Factory');
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

        $this->app->alias('commentrepository', 'App\Repositories\CommentRepository');
    }

    /**
     * Register category service.
     *
     * @return void
     */
    protected function registerCategoriesService()
    {
        $this->app->bind('App\Services\CategoriesService', function () {
            return new CategoriesService();
        });
    }

    /**
     * Register pages service.
     *
     * @return void
     */
    protected function registerPagesService()
    {
        $this->app->bind('App\Services\PagesService', function ($app) {
            return new PagesService($app->make('App\Services\GridService'));
        });
    }

    /**
     * Register configurations service.
     *
     * @return void
     */
    protected function registerConfigurationsService()
    {
        $this->app->bind('App\Services\ConfigurationsService', function () {
            return new ConfigurationsService();
        });
    }

    /**
     * Register media service.
     *
     * @return void
     */
    protected function registerMediaService()
    {
        $this->app->bind('App\Services\MediaService', function () {
            return new MediaService();
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

        $this->app->alias('eventrepository', 'App\Repositories\EventRepository');
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

        $this->app->alias('pagerepository', 'App\Repositories\PageRepository');
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

        $this->app->alias('postrepository', 'App\Repositories\PostRepository');
    }

    /**
     * Register the command subscriber class.
     *
     * @return void
     */
    protected function registerCommandSubscriber()
    {
        $this->app->singleton('App\Subscribers\CommandSubscriber', function ($app) {
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
        $this->app->singleton('App\Subscribers\NavigationSubscriber', function ($app) {
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
        $this->app->bind('App\Http\Controllers\CommentController', function ($app) {
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
