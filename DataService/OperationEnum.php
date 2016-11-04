<?php

namespace QuickBooks\DataService;

/**
 * Describes operations that can be included in a batch
 */
class OperationEnum {

    /**
     * create Operation
     * @var string create
     */
    const create = "create";

    /**
     * update Operation
     * @var string update
     */
    const update = "update";

    /**
     * sparse update Operation
     * @var string sparseupdate
     */
    const sparseupdate = "sparse update";

    /**
     * delete Operation
     * @var string delete
     */
    const delete = "delete";

    /**
     * void Operation
     * @var string void
     */
    const void = "void";

    /**
     * query Operation
     * @var string query
     */
    const query = "query";


    /**
     * report Operation
     * @var string report
     */
    const report = "report";
}