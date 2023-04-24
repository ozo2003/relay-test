<?php declare(strict_types = 1);

namespace App\Constants\Enum;

enum Definition: string
{
    case PROJECT = 'optimize';
    case PROJECT_CACHE_KEY = 'project.cache';

    case TYPE_HTML = 'text/html';
    case TYPE_JSON = 'application/json';
    case TYPE_JSONLD = 'application/ld+json';
    case TYPE_JSON_MERGE = 'application/merge-patch+json';
    case TYPE_MULTIPART_FORM = 'multipart/form-data';
    case TYPE_PLAIN = 'text/plain';
}
