<?php

namespace EventCal\Controllers\Admin;
use EventCal\Controllers\BaseController;
use EventCal\Models\User;
use EventCal\Models\Locality;

class UsersController extends BaseController {

	/**
	 * Display a listing of the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::getAllUsersForAdmin();
		return \View::make('admin.listing_users')->with('users', $users);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
// 	public function create()
// 	{
// 		//
// 	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
// 	public function store()
// 	{
// 		//
// 	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::findWithSociety($id);
		$events = $user->society ? $user->society->getAllEvents() : array();
		
		return \View::make('admin.show_user')->with(array(
			'user'   => $user,
			'events' => $events,
		));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return \View::make('admin.edit_user')->with(array(
			'user' => User::findWithSociety($id),
			'city' => Locality::getLocalitiesArray(),
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = \Input::all();
		$input['is_actif'] = \Input::has('is_actif') ? \Input::get('is_actif') : false;

		$errors = User::updateWithSociety($id, $input);
		
		if ($errors !== true)
		{
			return \Redirect::action('EventCal\Controllers\Admin\UsersController@edit', array($id))->withErrors($errors)->withInput();			
		}
		
		return \Redirect::action('EventCal\Controllers\Admin\UsersController@show', array($id))->with('notification', 'Màj réussie');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::deleteAllData($id);
		
		return \Redirect::action('EventCal\Controllers\Admin\UsersController@index')->with('notification', 'Suppression effectuée');
	}
	
	/**
	 * Activate the specified user with his id
	 * 
	 * @param int $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function putActivate($id)
	{
		$input['is_actif'] = true;
		
		User::updateWithSociety($id, $input);
		
		return \Redirect::action('EventCal\Controllers\Admin\UsersController@show', array($id))->with('notification', 'Utilisateur activé');
	}
	
}