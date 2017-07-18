<?php

namespace Mooshroom;

/**
 * Class SpigetAPI
 *
 * @author Camouflage100
 * @since  Spiget 2.0
 */
class SpigetAPI
{

    /**
     * The useragent that we'll be using
     */
    const user_agent = "Mooshroom/0.1";

    /**
     * Get a list of authors
     *
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getAuthors($size = 10, $page = 1, $sort = "", $fields = "")
    {
        $request = "authors";
        $request .= "?size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Send a request to the SpigetAPI
     *
     * @param string $method
     *
     * @return array
     */
    public static function request($method = "")
    {
        $options = stream_context_create(["http" => ["user_agent" => SpigetAPI::user_agent]]);

        $response = file_get_contents("https://api.spiget.org/v2/" . $method, false, $options);

        return $response;
    }

    /**
     * Search for an author using their name
     *
     * @param string $query
     * @param string $field
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function searchAuthor($query = "Camouflage100", $field = "name", $size = 10, $page = 1, $sort = "", $fields = "")
    {
        $request = "search/authors/" . $query;
        $request .= "?field=" . $field;
        $request .= "&size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Get an author from their ID
     *
     * @param int $author
     *
     * @return array
     */
    public static function getAuthor($author = 27452)
    {
        return self::request("authors/" . $author);
    }

    /**
     * Get an author's resources
     *
     * @param int    $author
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getAuthorResources($author = 27452, $size = 10, $page = 1, $sort = "", $fields = "")
    {
        $request = "authors/" . $author . "/resources";
        $request .= "?size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Get the reviews that an author has written
     *
     * @param int    $author
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getAuthorReviews($author = 27452, $size = 10, $page = 1, $sort = "", $fields = "")
    {
        $request = "authors/" . $author . "/reviews";
        $request .= "?size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Get the categories
     *
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getCategories($size = 10, $page = 1, $sort = "", $fields = "")
    {
        $request = "categories";
        $request .= "?size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Get the resources found in a specific category
     *
     * @param int    $category
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getCategoriesResources($category = 4, $size = 5, $page = 1, $sort = "", $fields = "")
    {
        $request = "categories/" . $category . "/resources";
        $request .= "?size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Get a category
     *
     * @param int $category
     *
     * @return array
     */
    public static function getCategory($category = 4)
    {
        return self::request("categories/" . $category);
    }

    /**
     * Get a list of resources
     *
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getResources($size = 5, $page = 1, $sort = "", $fields = "")
    {
        $request = "resources";
        $request .= "?size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Search for resources that are compatible with a specific version of Minecraft
     *
     * @param string $version
     * @param string $method
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getResourcesFor($version = "1.11", $method = "any", $size = 5, $page = 1, $sort = "", $fields = "")
    {
        $request = "resources/for/" . $version;
        $request .= "?method=" . $method;
        $request .= "&size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Get the recent new resources
     *
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getNewResources($size = 5, $page = 1, $sort = "", $fields = "")
    {
        $request = "resources/new";
        $request .= "?size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Get a resource
     *
     * @param int $resource
     *
     * @return array
     */
    public static function getResource($resource = 1223)
    {
        return self::request("resources/" . $resource);
    }

    /**
     * Get the author of a specified resource
     *
     * @param int $resource
     *
     * @return array
     */
    public static function getResourceAuthor($resource = 1223)
    {
        return self::request("resources/" . $resource . "/author");
    }

    /**
     * Download a resource from its latest version
     *
     * @param int $resource
     *
     * @return array
     */
    public static function downloadResource($resource = 1223)
    {
        return self::request("resources/" . $resource . "/download");
    }

    /**
     * Download a resource from a specified version.
     *
     * @param int $resource
     * @param int $version
     *
     * @return array
     */
    public static function downloadResourceVersion($resource = 1223, $version = 135548)
    {
        return self::request("resources/" . $resource . "/versions/" . $version . "/download/");
    }

    /**
     * Get the reviews of a resource
     *
     * @param int    $resource
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getResourceReviews($resource = 1223, $size = 5, $page = 1, $sort = "", $fields = "")
    {
        $request = "resources/" . $resource . "/reviews";
        $request .= "?size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Get the updates of a resource
     *
     * @param int    $resource
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getResourceUpdates($resource = 1223, $size = 5, $page = 1, $sort = "", $fields = "")
    {
        $request = "resources/" . $resource . "/updates";
        $request .= "?size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Get the versions of a resource
     *
     * @param int    $resource
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function getResourceVersions($resource = 1223, $size = 5, $page = 1, $sort = "", $fields = "")
    {
        $request = "resources/" . $resource . "/versions";
        $request .= "?size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Search for a resource
     *
     * @param string $query
     * @param string $field
     * @param int    $size
     * @param int    $page
     * @param string $sort
     * @param string $fields
     *
     * @return array
     */
    public static function searchResource($query = "Prison", $field = "name", $size = 10, $page = 1, $sort = "", $fields = "")
    {
        $request = "search/resources/" . $query;
        $request .= "?field=" . $field;
        $request .= "&size=" . $size;
        $request .= "&page=" . $page;
        if ($sort != "")
            $request .= "&sort=" . $sort;
        if ($fields != "")
            $request .= "&fields=" . $fields;

        return self::request($request);
    }

    /**
     * Get the status information of the Spiget API
     *
     * @return array
     */
    public static function getStatus()
    {
        return self::request("status");
    }

    /* Sorry, couldn't get the webhook methods to work :( */

}