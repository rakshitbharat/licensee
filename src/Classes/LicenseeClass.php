<?php

namespace Rakshitbharat\Licensee\Classes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use DB;
use Validator;

Class LicenseeClass {

    public static function dataToDB($request) {
        $user_table = Config('licensee.user_table');
        self::validator($request->all())->validate();
        if ($request->delete == 'yes' && $request->id) {
            DB::table($user_table . "_permission")->where($user_table . '_role_id', $request->id)->delete();
            DB::table($user_table . "_role")->where('id', $request->id)->delete();
            return self::dataFromDB($request);
        }
        $data = array();
        foreach ($request->all() as $key => $requestData) {
            if ($key != 'delete') {
                if (!is_array($requestData)) {
                    $data[$key] = $requestData;
                }
            }
        }
        if ($request->id) {
            DB::table($user_table . "_role")->where('id', $request->id)->update($data);
            $id = $request->id;
        } else {
            $id = DB::table($user_table . "_role")->insertGetId($data);
        }
        if ($request->permission) {
            foreach ($request->permission as $key => $checked) {
                if ($checked == 'true') {
                    $object = DB::table($user_table . "_permission")
                                    ->where($user_table . '_role_id', $id)
                                    ->where($user_table . '_permission_slug', $key)->count();
                    if ($object == 0) {
                        DB::table($user_table . "_permission")
                                ->insert([
                                    $user_table . '_permission_slug' => $key,
                                    $user_table . '_role_id' => $id,
                        ]);
                    }
                }
                if ($checked == 'false') {
                    $object = DB::table($user_table . "_permission")
                                    ->where($user_table . '_role_id', $id)
                                    ->where($user_table . '_permission_slug', $key)->count();
                    if ($object > 0) {
                        DB::table($user_table . "_permission")
                                ->where($user_table . '_role_id', $id)
                                ->where($user_table . '_permission_slug', $key)
                                ->delete();
                    }
                }
            }
        }
        return self::dataFromDB($request);
    }

    public static function dataFromDB($request) {
        $user_table = Config('licensee.user_table');
        $data = new \stdClass();
        $finalData = array();
        $finalPermission = array();
        $detected_permission = LicenseeClass::permissionCompressorURLWithBase();
        $list = DB::select("SELECT * FROM " . $user_table . '_role');
        if ($request->delete != 'yes' && $request->id) {
            $data = DB::select("SELECT * FROM " . $user_table . "_role where id=" . $request->id)[0];
            $permission = DB::select("SELECT " . $user_table . "_permission_slug FROM " . $user_table . "_permission where
                 " . $user_table . "_role_id = " . $data->id);
            $permission_slug = $user_table . '_permission_slug';
            foreach ($permission as $key => $permissions) {
                $finalPermission[$permissions->$permission_slug] = $key;
            }
        }
        foreach ($detected_permission as $key => $detected_permissions) {
            foreach ($detected_permissions as $keyInner => $valueInner) {
                $checked = false;
                if (array_key_exists($valueInner, $finalPermission)) {
                    $checked = true;
                }
                $finalData[$key][$keyInner]['name'] = $valueInner;
                $finalData[$key][$keyInner]['checked'] = $checked;
            }
        }
        $data->permission = $finalData;
        return array(
            'data' => $data,
            'list' => $list,
        );
    }

    public static function permissionCompressorURLWithBase() {
        $routeCollection = Route::getRoutes();
        $permission = array();
        foreach ($routeCollection as $value) {
            if (array_key_exists('permission_area_name_inroute', $value->action)) {
                if (array_key_exists('permission_area_name_prefix_inroute', $value->action)) {
                    $permission[$value->action['permission_area_name_prefix_inroute']] = self::split($value->action);
                }
            }
        }
        foreach (Config('licensee.manual_permission') as $key => $manual_permission) {
            foreach ($manual_permission as $keyInner => $manual_permissions) {
                $permission[$key][$keyInner] = $key . '_' . $manual_permissions;
            }
        }
        return $permission;
    }

    public static function split($DeclaredPermission) {
        if (strpos($DeclaredPermission['permission_area_name_inroute'], '|') != '') {
            foreach (explode('|', $DeclaredPermission['permission_area_name_inroute']) as $permission_area_name_inroute) {
                $permissionIndividual[] = $DeclaredPermission['permission_area_name_prefix_inroute'] . '_' . $permission_area_name_inroute;
            }
        } else {
            $permissionIndividual[] = $DeclaredPermission['permission_area_name_inroute'] . '_' . $permission_area_name_inroute;
        }
        return $permissionIndividual;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $request
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected static function validator($request) {
        $user_table = Config('licensee.user_table');
        return Validator::make(
                        $request, [
                    $user_table . '_role_slug' => 'required||unique:' . $user_table . '_role,' . $user_table . '_role_slug' . ',' . $request['id'] . '',
                    $user_table . '_role_description' => 'required',
                    'permission' => 'required',
        ]);
    }

}
