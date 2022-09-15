# Types

  * [`ComponentsMessagesDimLightPayload`](#componentsmessagesdimlightpayload)
  * [`ComponentsMessagesLightMeasuredPayload`](#componentsmessageslightmeasuredpayload)
  * [`ComponentsMessagesTurnOnOffPayload`](#componentsmessagesturnonoffpayload)
  * [`DimLightPayloadPercentage`](#dimlightpayloadpercentage)
  * [`LightMeasuredPayloadLumens`](#lightmeasuredpayloadlumens)




### <a id="componentsmessagesdimlightpayload"></a>ComponentsMessagesDimLightPayload



|Property    |Type                                                               |Description                                       |
|------------|-------------------------------------------------------------------|--------------------------------------------------|
|`percentage`|[`DimLightPayloadPercentage`](#dimlightpayloadpercentage), `Number`|Percentage to which the light should be dimmed to.|
|`sentAt`    |`String`, Format: `date-time`                                      |Date and time when the message was sent (updated).|


### <a id="componentsmessageslightmeasuredpayload"></a>ComponentsMessagesLightMeasuredPayload



|Property|Type                                                                 |Description                                       |
|--------|---------------------------------------------------------------------|--------------------------------------------------|
|`lumens`|[`LightMeasuredPayloadLumens`](#lightmeasuredpayloadlumens), `Number`|Light intensity measured in lumens (updated).     |
|`sentAt`|`String`, Format: `date-time`                                        |Date and time when the message was sent (updated).|


### <a id="componentsmessagesturnonoffpayload"></a>ComponentsMessagesTurnOnOffPayload



|Property |Type                         |Description                                       |
|---------|-----------------------------|--------------------------------------------------|
|`command`|`'on'`, <br>`'off'`          |Whether to turn on or off the light.              |
|`sentAt` |`String`, Format: `date-time`|Date and time when the message was sent (updated).|


### <a id="dimlightpayloadpercentage"></a>DimLightPayloadPercentage
Percentage to which the light should be dimmed to.

|Constraint|Value|
|----------|-----|
|maximum   |100  |
|minimum   |0    |




### <a id="lightmeasuredpayloadlumens"></a>LightMeasuredPayloadLumens
Light intensity measured in lumens (updated).

|Constraint|Value|
|----------|-----|
|minimum   |0    |


