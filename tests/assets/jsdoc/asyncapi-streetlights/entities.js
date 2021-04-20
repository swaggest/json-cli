/**
 * @typedef ComponentsMessagesLightMeasuredPayload
 * @type {Object}
 * @property {Number} lumens - Light intensity measured in lumens (updated).
 * @property {String} sentAt - Date and time when the message was sent (updated).
 */

/**
 * @typedef ComponentsMessagesTurnOnOffPayload
 * @type {Object}
 * @property {('on'|'off')} command - Whether to turn on or off the light.
 * @property {String} sentAt - Date and time when the message was sent (updated).
 */

/**
 * @typedef ComponentsMessagesDimLightPayload
 * @type {Object}
 * @property {Number} percentage - Percentage to which the light should be dimmed to.
 * @property {String} sentAt - Date and time when the message was sent (updated).
 */

