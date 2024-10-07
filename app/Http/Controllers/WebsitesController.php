<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\WebsiteCreateRequest;
use App\Http\Requests\WebsiteUpdateRequest;
use App\Interfaces\WebsiteRepository;
use App\Validators\WebsiteValidator;

/**
 * Class WebsitesController.
 *
 * @package namespace App\Http\Controllers;
 */
class WebsitesController extends Controller
{
    /**
     * @var WebsiteRepository
     */
    protected $repository;

    /**
     * @var WebsiteValidator
     */
    protected $validator;

    /**
     * WebsitesController constructor.
     *
     * @param WebsiteRepository $repository
     * @param WebsiteValidator $validator
     */
    public function __construct(WebsiteRepository $repository, WebsiteValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $websites = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $websites,
            ]);
        }

        return view('websites.index', compact('websites'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WebsiteCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(WebsiteCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $website = $this->repository->create($request->all());

            $response = [
                'message' => 'Website created.',
                'data'    => $website->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $website = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $website,
            ]);
        }

        return view('websites.show', compact('website'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $website = $this->repository->find($id);

        return view('websites.edit', compact('website'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WebsiteUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(WebsiteUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $website = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Website updated.',
                'data'    => $website->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Website deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Website deleted.');
    }
}
