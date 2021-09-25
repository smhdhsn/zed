<?php

namespace Zed\Framework;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
class Response
{
    /**
     * Status words.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    CONST WRONG = "Entried data wasn't correct.";
    CONST ACCESS = "You don't have access.";
    CONST INVALID_ROUTE = "Invalid route.";
    CONST PAGENOTFOUND = "Page not found.";
    CONST UNAUTHORIZED = "Unauthorized.";
    CONST NOTFOUND = "Item not found.";
    CONST REMOVED = "Removed.";
    CONST SUCCESS = "Success.";
    CONST ERROR = "Error.";
    CONST ADDED = "Added.";

    /**
     * Response codes.
     * 
     * @since 1.0.0
     * 
     * @var int
     */
    CONST HTTP_CONTINUE = 100;
    CONST HTTP_SWITCHING_PROTOCOLS = 101;
    CONST HTTP_PROCESSING = 102;            // RFC2518
    CONST HTTP_OK = 200;
    CONST HTTP_CREATED = 201;
    CONST HTTP_ACCEPTED = 202;
    CONST HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    CONST HTTP_NO_CONTENT = 204;
    CONST HTTP_RESET_CONTENT = 205;
    CONST HTTP_PARTIAL_CONTENT = 206;
    CONST HTTP_MULTI_STATUS = 207;          // RFC4918
    CONST HTTP_ALREADY_REPORTED = 208;      // RFC5842
    CONST HTTP_IM_USED = 226;               // RFC3229
    CONST HTTP_MULTIPLE_CHOICES = 300;
    CONST HTTP_MOVED_PERMANENTLY = 301;
    CONST HTTP_FOUND = 302;
    CONST HTTP_SEE_OTHER = 303;
    CONST HTTP_NOT_MODIFIED = 304;
    CONST HTTP_USE_PROXY = 305;
    CONST HTTP_RESERVED = 306;
    CONST HTTP_TEMPORARY_REDIRECT = 307;
    CONST HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    CONST HTTP_BAD_REQUEST = 400;
    CONST HTTP_UNAUTHORIZED = 401;
    CONST HTTP_PAYMENT_REQUIRED = 402;
    CONST HTTP_FORBIDDEN = 403;
    CONST HTTP_NOT_FOUND = 404;
    CONST HTTP_METHOD_NOT_ALLOWED = 405;
    CONST HTTP_NOT_ACCEPTABLE = 406;
    CONST HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    CONST HTTP_REQUEST_TIMEOUT = 408;
    CONST HTTP_CONFLICT = 409;
    CONST HTTP_GONE = 410;
    CONST HTTP_LENGTH_REQUIRED = 411;
    CONST HTTP_PRECONDITION_FAILED = 412;
    CONST HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    CONST HTTP_REQUEST_URI_TOO_LONG = 414;
    CONST HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    CONST HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    CONST HTTP_EXPECTATION_FAILED = 417;
    CONST HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    CONST HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    CONST HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    CONST HTTP_LOCKED = 423;                                                      // RFC4918
    CONST HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918
    CONST HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
    CONST HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    CONST HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    CONST HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    CONST HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    CONST HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    CONST HTTP_INTERNAL_SERVER_ERROR = 500;
    CONST HTTP_NOT_IMPLEMENTED = 501;
    CONST HTTP_BAD_GATEWAY = 502;
    CONST HTTP_SERVICE_UNAVAILABLE = 503;
    CONST HTTP_GATEWAY_TIMEOUT = 504;
    CONST HTTP_VERSION_NOT_SUPPORTED = 505;
    CONST HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    CONST HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    CONST HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    CONST HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    CONST HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585

    /**
     * Response words.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    CONST WORD = [
        100 => 'Continue',
        101 => 'Switching protocols',
        102 => 'Processing',            // RFC2518
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative information',
        204 => 'No content',
        205 => 'Reset content',
        206 => 'Partial content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already reported',      // RFC5842
        226 => 'I\'m used',               // RFC3229
        300 => 'Multiple choices',
        301 => 'Moved permanently',
        302 => 'Found',
        303 => 'See other',
        304 => 'Not modified',
        305 => 'Use proxy',
        307 => 'Temporary redirect',
        308 => 'Permanent redirect',    // RFC7238
        400 => 'Bad request',
        401 => 'Unauthorized',
        402 => 'Payment required',
        403 => 'Forbidden',
        404 => 'Not found',
        405 => 'Method not allowed',
        406 => 'Not acceptable',
        407 => 'Proxy authentication required',
        408 => 'Request timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length required',
        412 => 'Precondition failed',
        413 => 'Payload too large',
        414 => 'URI too long',
        415 => 'Unsupported media type',
        416 => 'Range not satisfiable',
        417 => 'Expectation failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        421 => 'Misdirected request',                                         // RFC7540
        422 => 'Unprocessable entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed dependency',                                           // RFC4918
        425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
        426 => 'Upgrade required',                                            // RFC2817
        428 => 'Precondition required',                                       // RFC6585
        429 => 'Too many requests',                                           // RFC6585
        431 => 'Request header fields too large',                             // RFC6585
        451 => 'Unavailable for legal reasons',                               // RFC7725
        500 => 'Internal server error',
        501 => 'Not implemented',
        502 => 'Bad gateway',
        503 => 'Service unavailable',
        504 => 'Gateway timeout',
        505 => 'HTTP version not supported',
        506 => 'Variant also negotiates',                                     // RFC2295
        507 => 'Insufficient storage',                                        // RFC4918
        508 => 'Loop detected',                                               // RFC5842
        510 => 'Not extended',                                                // RFC2774
        511 => 'Network authentication required',                             // RFC6585
    ];
}
