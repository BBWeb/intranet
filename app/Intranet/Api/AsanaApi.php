<?php namespace Intranet\Api;

/**
 * AsanaApi-Class connect to the asana api
 * some helper functions e.g. getWorkspaces, getProjects,...
 *
 * @author codelovers
 * @author codelovers.de
 * @version 1.0 (2012_07_07)
 * @package asana_track_time
 */

class AsanaApi {

    // ##############################################################################################
    // CLASS VARIABLES & CONSTANTS
    // ##############################################################################################
    // variables
    private $apiKey, $uri, $workspaceUri, $responseCode;

    // set constants
    const PUT_METHOD  = 2;
    const GET_METHOD  = 3;

    // ##############################################################################################
    // CONSTRUCTOR
    // ##############################################################################################
    public function __construct($apiKey){

        // : away, append it
        if(substr($apiKey, -1) != ":"){
          $apiKey .= ":";
        }

        // initialize needed values
        $this->apiKey = $apiKey;
        $this->uri = "https://api.asana.com/api/1.0/";
        $this->workspaceUri = $this->uri."workspaces"; //
        $this->projectUri = $this->uri."projects";
        $this->taskUri = $this->uri."tasks";
        $this->userUri = $this->uri."users";
    }

    // ##############################################################################################
    // SETTER & GETTER & HELPER METHODS
    // ##############################################################################################
    public function getUserId(){
        $resultJson = json_decode($this->apiRequest($this->userUri.'/me'));
        return $resultJson->data->id;
    }

    public function getResponseCode(){
        return $this->responseCode;
    }

    public function getWorkspaces(){
        return $this->apiRequest($this->workspaceUri);
    }

    public function getProjects($workspaceId) {
       $resultJson = json_decode( $this->apiRequest( $this->workspaceUri . '/' . $workspaceId . '/projects' ) );
       $projects = $resultJson->data;
       return $projects;
    }

    public function getTasks($workspaceId)
    {
       return $this->apiRequest($this->workspaceUri . '/' . $workspaceId . '/tasks?assignee=me');
    }

    public function getModifiedTasks($workspaceId, $lastQueryTime)
    {
       return $this->apiRequest($this->workspaceUri . '/' . $workspaceId . '/tasks?assignee=me&modified_since=' . urlencode($lastQueryTime));
    }

    public function getProjectTasks($projectId)
    {
          return $this->apiRequest($this->projectUri . '/' . $projectId . '/tasks?assignee=me');
    }

    public function getParentProject($taskId)
    {
        $resultJson = json_decode($this->apiRequest($this->taskUri.'/'.$taskId));

        // check if this one has a project, then return it
        if (array_key_exists(0, $resultJson->data->projects)) {
            return $resultJson->data->projects[0];
        }

        // otherwise we assume that the task has a parent
        return $this->getParentProject($resultJson->data->parent->id);
    }

    public function getOneTask($taskId){
        $resultJson = json_decode($this->apiRequest($this->taskUri.'/'.$taskId));

        $projectData = array();

        if(array_key_exists(0, $resultJson->data->projects)) {
            $projectData = (array)$resultJson->data->projects[0];
        }
        elseif(is_object($resultJson->data->parent)){
            // TODO we really need to integrate this more with redis cache
            //  In some cases we may already have the parent, and in others we want to cache it
            //  For now this should do the trick though
            $parentProject = $this->getParentProject($resultJson->data->parent->id);

            $projectData = (array) $parentProject;
            // $castIntoArray = array(
            //                     'id' => $resultJson->data->parent->id,
            //                     'name' => 'PARENT TASK: '.$resultJson->data->parent->name
            //                  );
        }
        else{
            $projectData = array(
                                'id' => $resultJson->data->id,
                                'name' => 'NO PROJECT'
                             );
        }

        $taskData = [
            'name' => $resultJson->data->name,
            'completed' => $resultJson->data->completed,
            'projects' => $projectData
        ];

        return $taskData;
    }

    public function checkTaskExistance($taskId)
    {
        // send a req, see whats returned
        $resultJson = json_decode($this->apiRequest($this->taskUri.'/'.$taskId));

        return $resultJson;
    }

    // ##############################################################################################
    // ASK ASANA API AND RETURN DATA
    // ##############################################################################################
    private function apiRequest($url, $givenData = null, $method = self::GET_METHOD){

        // ask asana api and return data
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_USERPWD, $this->apiKey);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // don´t print json-string
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); // Send as JSON

        if($method == self::PUT_METHOD){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $givenData);
        }

        $data = curl_exec($curl);

        // set responsCode, needed in index.php
        $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return $data;
    }
}
