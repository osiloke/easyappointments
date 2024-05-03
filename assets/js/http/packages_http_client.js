/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.5.0
 * ---------------------------------------------------------------------------- */

/**
 * Packages HTTP client.
 *
 * This module implements the packages related HTTP requests.
 */
App.Http.Packages = (function () {
    /**
     * Save (create or update) a package.
     *
     * @param {Object} package
     *
     * @return {Object}
     */
    function save(data) {
        return data.id ? update(data) : create(data);
    }

    /**
     * Create a package.
     *
     * @param {Object} package
     *
     * @return {Object}
     */
    function create(v) {
        const url = App.Utils.Url.siteUrl('packages/store');

        const data = {
            csrf_token: vars('csrf_token'),
            package: v,
        };

        return $.post(url, data);
    }

    /**
     * Update a package.
     *
     * @param {Object} package
     *
     * @return {Object}
     */
    function update(v) {
        const url = App.Utils.Url.siteUrl('packages/update');

        const data = {
            csrf_token: vars('csrf_token'),
            package: v,
        };

        return $.post(url, data);
    }

    /**
     * Delete a package.
     *
     * @param {Number} packageId
     *
     * @return {Object}
     */
    function destroy(packageId) {
        const url = App.Utils.Url.siteUrl('packages/destroy');

        const data = {
            csrf_token: vars('csrf_token'),
            package_id: packageId,
        };

        return $.post(url, data);
    }

    /**
     * Search packages by keyword.
     *
     * @param {String} keyword
     * @param {Number} [limit]
     * @param {Number} [offset]
     * @param {String} [orderBy]
     *
     * @return {Object}
     */
    function search(keyword, limit = null, offset = null, orderBy = null) {
        const url = App.Utils.Url.siteUrl('packages/search');

        const data = {
            csrf_token: vars('csrf_token'),
            keyword,
            limit,
            offset,
            order_by: orderBy,
        };

        return $.post(url, data);
    }

    /**
     * Find a package.
     *
     * @param {Number} packageId
     *
     * @return {Object}
     */
    function find(packageId) {
        const url = App.Utils.Url.siteUrl('packages/find');

        const data = {
            csrf_token: vars('csrf_token'),
            package_id: packageId,
        };

        return $.post(url, data);
    }

    return {
        save,
        create,
        update,
        destroy,
        search,
        find,
    };
})();
