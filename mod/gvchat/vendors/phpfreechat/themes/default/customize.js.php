/**
 * Put here the pfcClient, pfcGui, pfcResources customizations
 * ex: you can override the pfcClient::updateNickList methode
 *     in order to display links on the nicknames (see demo34 for a concrete example)
 */

pfcClient.prototype.updateNickWhoisBox_ignored_field = function(k)
{
      return true;
}
 
