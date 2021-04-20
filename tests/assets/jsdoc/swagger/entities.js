/**
 * Contact information for the owners of the API.
 * @typedef Contact
 * @type {Object}
 * @property {String} name - The identifying name of the contact person/organization.
 * @property {String} url - The URL pointing to the contact information.
 * @property {String} email - The email address of the contact person/organization.
 */

/**
 * @typedef License
 * @type {Object}
 * @property {String} name - The name of the license type. It's encouraged to use an OSI compatible license.
 * @property {String} url - The URL pointing to the license.
 */

/**
 * General information about the API.
 * @typedef Info
 * @type {Object}
 * @property {String} title - A unique and precise title of the API.
 * @property {String} version - A semantic version number of the API.
 * @property {String} description - A longer description of the API. Should be different from the title.  GitHub Flavored Markdown is allowed.
 * @property {String} termsOfService - The terms of service for the API.
 * @property {Contact|Object|Array} contact - Contact information for the owners of the API.
 * @property {License|Object|Array} license
 */

