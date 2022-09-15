# Types

  * [`Contact`](#contact)
  * [`Info`](#info)
  * [`License`](#license)




### <a id="contact"></a>Contact
Contact information for the owners of the API.



|Property|Type                     |Description                                             |
|--------|-------------------------|--------------------------------------------------------|
|`name`  |`String`                 |The identifying name of the contact person/organization.|
|`url`   |`String`, Format: `uri`  |The URL pointing to the contact information.            |
|`email` |`String`, Format: `email`|The email address of the contact person/organization.   |


### <a id="info"></a>Info
General information about the API.



|Property            |Type                                    |Description                                                                                               |
|--------------------|----------------------------------------|----------------------------------------------------------------------------------------------------------|
|`title` (required)  |`String`                                |A unique and precise title of the API.                                                                    |
|`version` (required)|`String`                                |A semantic version number of the API.                                                                     |
|`description`       |`String`                                |A longer description of the API. Should be different from the title.  GitHub Flavored Markdown is allowed.|
|`termsOfService`    |`String`                                |The terms of service for the API.                                                                         |
|`contact`           |[`Contact`](#contact), `Object`, `Array`|Contact information for the owners of the API.                                                            |
|`license`           |[`License`](#license), `Object`, `Array`|                                                                                                          |


### <a id="license"></a>License



|Property         |Type                   |Description                                                                    |
|-----------------|-----------------------|-------------------------------------------------------------------------------|
|`name` (required)|`String`               |The name of the license type. It's encouraged to use an OSI compatible license.|
|`url`            |`String`, Format: `uri`|The URL pointing to the license.                                               |
