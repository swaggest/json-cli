/**
 * Contact information for the owners of the API.
 * @typedef Contact
 * @type {object}
 * @property {string} name - The identifying name of the contact person/organization.
 * @property {string} url - The URL pointing to the contact information.
 * @property {string} email - The email address of the contact person/organization.
 */

/**
 * @typedef License
 * @type {object}
 * @property {string} name - The name of the license type. It's encouraged to use an OSI compatible license.
 * @property {string} url - The URL pointing to the license.
 */

/**
 * General information about the API.
 * @typedef Info
 * @type {object}
 * @property {string} title - A unique and precise title of the API.
 * @property {string} version - A semantic version number of the API.
 * @property {string} description - A longer description of the API. Should be different from the title.  GitHub Flavored Markdown is allowed.
 * @property {string} termsOfService - The terms of service for the API.
 * @property {Contact} contact - Contact information for the owners of the API.
 * @property {License} license.
 */

