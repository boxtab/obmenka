<?php

if (!function_exists('userOwnRole')) {
    /**
     * Определяет есть ли роль пользователя вэтом списке.
     *
     * @param string $listRole
     * Текстовый список ролей разделенных слэшами.
     *
     * @param int $roleUser
     * id роли пользователя.
     *
     * @return bool истина если роль пользователя попадает в этот список.
     *
     * */
    function userOwnRole( string $listRole, int $roleUser ): bool
    {
        $authRoleId = $roleUser;
        $authRoleSlug = array_search( $authRoleId, Config('constants.role') );
        $transferArrayRole = explode('/', $listRole);

        return ( in_array( $authRoleSlug, $transferArrayRole ) ) ? true : false;
    }
}
