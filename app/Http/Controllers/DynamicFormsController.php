<?php

/**
 * Class
 *
 * PHP version 7.2
 */

namespace App\Http\Controllers;

//change the request class if needed
use Illuminate\Support\Carbon;

use App\Models\DynamicForm as Entity;
use App\Http\Resources\Select2\FormField as Resource;

/*
 * - Model <use> statements:
 *      When you have a Controller tailored towards a certain Model entity,
 *      this Model should be <use>-ed as "Entity". For example,
 *      in a BuildingsController class, the Building Model should be included
 *      like so:
 *      <code>
 *          use App\Models\Building as Entity;
 *      </code>
 *      Likewise, if you want to instantiate an Entity, the variable which holds
 *      the instance should be named $entity.
 *      This should be AVOIDED on Controllers that are NOT tailored to a
 *      Model CRUD.
 *
 * Method order should stay the same as in routes.
 *
 */
use Illuminate\Http\Request as Request;
use App\Http\Resources\Json as JsonResource;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\OtherProductCategory;
use App\Models\ProductCategory;
use Illuminate\Http\Resources\Json\Resource as ResourcesJsonResource;
use Psy\Command\EditCommand;

/**
 * Example Controller for describing standards
 */
class DynamicFormsController extends Controller
{
    /**
     * @var Request
     */
    protected $request;
    protected $namespace = 'dynamicforms.';

    /**
     * The Controller constructor is primarily used for dependency injection...
     *
     * @link https://laravel.com/docs/5.7/controllers#dependency-injection-and-controllers
     *
     * and for registering middlewares.
     * @link https://laravel.com/docs/5.7/controllers#controller-middleware
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        /*
         * Middlewares for global scopes on models
         * Each Model should have its own separate middleware!!!
         */

        $this->middleware(function ($request, $next) {
            //Model 1

            Entity::addGlobalScope(function ($query) {

                //limit field on logged in user id for example
                $query->my();
            });

            return $next($request);
        });
    }

    /**
     * Public methods: always exposed via routes. The first arguments MUST be
     * services resolved by dependency injection, then any entities passed via
     * route parameters.
     *
     * Any other public method would repeat most of the steps, if needed, of
     * course, but would do its own thing like Job queuing,
     * Event dispatching, or any other business logic.
     */
    public function all()
    {
        return view($this->namespace . 'all');
    }

    public function datatable()
    {
        return
            datatables(Entity::query())
            ->editColumn('form_id', '{{str_cut($form_id, 30)}}')
            ->editColumn('title', '{{str_cut($title, 30)}}')
            ->editColumn('seo_title', '{{str_cut($seo_title, 30)}}')
            ->editColumn('description', '{{str_cut($description, 30)}}')
            ->editColumn('seo_description', '{{str_cut($seo_description, 30)}}')
            ->editColumn('car_condition ', '{{str_cut($car_condition, 30)}}')
            ->editColumn('equipments', '{{str_cut($equipments, 30)}}')
            ->editColumn('fuel ', '{{str_cut($fuel , 30)}}')
            ->addColumn('actions', function ($entity) {
                return view($this->namespace . 'partials.table.actions', compact('entity'));
            })
            ->rawColumns(['actions'])
            ->setRowAttr([
                'data-id' => function ($entity) {
                    return $entity->id;
                },
            ])
            ->make(true);
    }

    public function create()
    {
        $request = $this->request;

        return view($this->namespace . 'create', [
            'entity' => new Entity(), // passed to avoid existence check on view script
        ]);
    }

    public function store()
    {
        $request = $this->request;

        #1 validation
        $data = $request->validate($this->validationRules());

        #2 normalization = remove keys from $data that are files, and filter/normalize some values

        #3 business logic check and throw ValidationException
        $data['created_by'] = auth()->user()->id;
        $data['form_id'] = $request['form_id'];
        if(!empty($request['equipments'])){
            $data['equipments'] = implode(',', $request['equipments']);
        }        
        #4 model population
        $entity = new Entity();
        $entity->fill($data);

        #5 saving data
        $entity->save();

        $entity->storeImage('original', request('image'));
        #6 Return propper response

        // if ajax call is in place return JsonResource with message
        if ($request->wantsJson()) {
            return JsonResource::make()->withSuccess(__('Entity has been saved!'));
        }

        //redirection with a message
        return redirect()->route($this->namespace . 'list')->withSystemSuccess(__('Entity has been saved!'));
    }

    /**
     * @param Entity $entity
     *
     * @return type
     */
    public function edit(Entity $entity)
    {
        $request = $this->request;

        return view($this->namespace . 'edit', [
            'entity' => $entity,
        ]);
    }

    public function update(Entity $entity)
    {
        $request = $this->request;


        #1 validation
        $data = $request->validate($this->validationRules());

        #3 business logic check and throw ValidationException
        $data['created_by'] = auth()->user()->id;
        $data['form_id'] = $request['form_id'];
        if(!empty($request['equipments'])){
            $data['equipments'] = implode(',', $request['equipments']);
        }  

        #4 model population
        $entity->fill($data);
        #5 saving data
        $entity->save();
        
        $entity->storeImage('edit-original', request('image'));

        #6 Return propper response

        // if ajax call is in place return JsonResource with message
        if ($request->wantsJson()) {
            return JsonResource::make()->withSuccess(__('Entity has been saved!'));
        }

        //redirection with a message
        return redirect()->route($this->namespace . 'list')->withSystemSuccess(__('Entity has been saved!'));
    }

    /**
     * Handles deletion of the Entity around which this controller revolves.
     * Important issues:
     *      #1 only expose this method via routes with the POST or DELETE method
     *      #2 $entity->delete(); is the only appropriate way to delete a model;
     *          Whether its soft- or hard- delete, should be defined
     *          in the model itself
     */
    public function delete(Entity $entity)
    {
        $entity->delete();

        // if ajax call is in place return JsonResource with message
        if ($this->request->wantsJson()) {
            return JsonResource::make()->withSuccess(__('Entity has been deleted!'));
        }
        //redirection with a message
        return redirect()->route($this->namespace . 'list')->withSystemSuccess(__('Entity has been deleted!'));
    }


    public function selection()
    {
        $entityQuery = Entity::query();

        $data = request()->validate([
            'term' => 'nullable|string',
        ]);

        if (!empty($data['term'])) {
            $entityQuery->where('name', 'like', '%' . $data['term'] . '%');
        }

        return Resource::collection($entityQuery->get());
    }

    /**
     * Handles change in any one column. In this case it is a column that
     * denotes entity activity, and will be appropriately called 'active'.
     * Important rules:
     *      #1 only expose this method via routes with the POST or PATCH method
     *      #2 this method only changes the specified column and returns
     *          an appropriate response
     *      #3 other business logic associated with this change must be
     *          delegated to Event Listeners and/or Jobs
     */

    /**
     * Protected/Private methods: used to uphold the single responsibility
     * principle, for bits and pieces of code that are repeated throughout the
     * same Controller or any other Controller which extends this one.
     * If there are pieces of logic that reoccur on the project all the time,
     * use of traits is encouraged.
     */
    protected function helperFunction()
    {
    }

    protected function validationRules($task = 'create')
    {
        $rules = [];
        switch (request('form_id')) {
            case '1':
                $rules = [
                    'title' => 'required|string|min:3|max:30',
                    'description' => 'required|string|min:3|max:191',
                ];
                break;

            case '2':
                $rules = [
                    'equipments' => 'required|array|min:1',
                    'equipments.*' => 'required|numeric|in:1,2,3',
                    'car_condition' => 'required|string|in:new,used,broken',
                ];
                break;

            case '3':
                $rules = [
                    'title' => 'required|string|min:3|max:30',
                    'fuel' => 'required|string|in:gasoline,diesel,gas',
                    'image' => 'required|file|image',
                ];
                break;

            case '4':
                $rules = [
                    'title' => 'required|string|min:3|max:30',
                    'description' => 'required|string|min:3|max:191',
                    'seo_title' => 'required|string|min:3|max:30',
                    'seo_description' => 'required|string|min:3|max:191',
                ];
                break;
        }
        return $rules;
    }
}
