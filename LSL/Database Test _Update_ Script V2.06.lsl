//start_unprocessed_text
/*/|/ ----------------------------------------------------------------------------------
/|/ Database Test "Info" Script V2.06
/|/ ----------------------------------------------------------------------------------
/|/ Copyright (c) 2014, Jenni Eales. All rights reserved.
/|/ ----------------------------------------------------------------------------------
/|/ Changes:
/|/ ----------------------------------------------------------------------------------
/|/ Version 1.0
/|/ - first version released
/|/ ----------------------------------------------------------------------------------
/|/
/|/ constants
integer DEBUG           = TRUE;
string HTTP_HOSTNAME     = "http:/|/oyobreedables.com/";
string HTTP_INFO_PHP    = "index.php?option=com_breedable&view=configuration&task=configuration.Update";

/|/ internal use
key http_request_id = NULL_KEY;

string getLocation()
{
    vector pos = llGetPos();
    return llGetRegionName() + " (" + (string) llRound(pos.x) + ", " + (string) llRound(pos.y) + ", " + (string) llRound(pos.z) + ")";
}

log(string message)
{
    if (DEBUG) llOwnerSay(message);
}

set_location(key id)
{
    string url = HTTP_HOSTNAME + HTTP_INFO_PHP;
    url += "&breedable_key=" + (string) id;
    url += "&owner_name="             + llEscapeURL(llKey2Name(llGetOwner()));
    url += "&owner_key="              + (string) llGetOwner();
    url += "&location="               + llEscapeURL(getLocation());

    /|/ update mode
    url += "&mode="  + llEscapeURL("location");

    /|/ output raw
    url += "&format="  + llEscapeURL("raw");
    
    log("request: " + url + " (" + (string) llStringLength(url) + " char)");

    /|/ send request
    http_request_id = llHTTPRequest(url, [HTTP_METHOD, "GET"], "");
}
set_name(key id, string name)
{
    string url = HTTP_HOSTNAME + HTTP_INFO_PHP;
    url += "&breedable_key=" + (string) id;
    url += "&breedable_name="             + llEscapeURL(name);
    url += "&owner_name="             + llEscapeURL(llKey2Name(llGetOwner()));
    url += "&owner_key="              + (string) llGetOwner();
    url += "&location="               + llEscapeURL(getLocation());

    /|/ update mode
    url += "&mode="  + llEscapeURL("rename");

    /|/ output raw
    url += "&format="  + llEscapeURL("raw");
    
    log("request: " + url + " (" + (string) llStringLength(url) + " char)");

    /|/ send request
    http_request_id = llHTTPRequest(url, [HTTP_METHOD, "GET"], "");
}
/|*
set_info(integer id, string message)
{
    string url = HTTP_HOSTNAME + HTTP_INFO_PHP;
    url += "&id=" + (string) id;
    url += "&mode=" + (string) mode;

    url += "&breedable_name"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_key"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&owner_name"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&owner_key"                 + (string) llEscapeURL(TXT_STATUS);
    
    url += "&status"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&version"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&generation"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_dob"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_gender"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_coat"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_eyes"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_food"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_health"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_fevor"                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_walk="                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_range="                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_terrain="                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_sound="                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_title="                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_pregnant="                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_mane="                 + (string) llEscapeURL(TXT_STATUS);
    url += "&breedable_mate="                 + (string) llEscapeURL(TXT_STATUS);
    url += "&location="                 + (string) llEscapeURL(TXT_STATUS);

    /|/ output raw
    url += "&format="  + llEscapeURL("raw");
    
    log("request: " + url + " (" + (string) llStringLength(url) + " char)");

    /|/ send request
    http_request_id = llHTTPRequest(url, [HTTP_METHOD, "GET"], "");
}
*|/
display_result(string body)
{
    /|/body = (string)llParseString2List(body, ["<br />"], []);
    llSay(0, body);
    
}

default
{
    touch_start(integer total_number)
    {
        /|/set_location(llGetKey()); /|/ update breeds location
          set_name(llGetKey(),llGetObjectName());
    }

    /|/ answer of http response
    http_response(key request_id, integer status, list metadata, string body)
    {
        if(http_request_id == request_id)
        {
            log("status: " + (string) status);
            if (status == 400)
                log("Bad Request");            
            if (status == 401)
                log("Unauthorized");            
            if (status == 403)
                log("Forbidden");            
            if (status == 404)
                log("Page not found");            
            else if (status == 500)
                log("Service not available");
            else if (status >= 300)
                log("Unknown error: " + (string) status);
            else
                display_result(body);            
        }
    }
}

/|/ ----------------------------------------------------------------------------------
/|/ Redistribution and use in source and binary forms, with or without modification,
/|/ are permitted provided that the following conditions are met:
/|/
/|/    * Redistributions of source code must retain the above copyright notice,
/|/      this list of conditions and the following disclaimer.
/|/    * Redistributions in binary form must reproduce the above copyright notice,
/|/      this list of conditions and the following disclaimer in the documentation
/|/      and/or other materials provided with the distribution.
/|/    * The names of its contributors may not be used to endorse or promote products
/|/      derived from this software without specific prior written permission.
/|/
/|/ THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
/|/ EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
/|/ OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
/|/ IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
/|/ INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
/|/ BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA,
/|/ OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
/|/ WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
/|/ ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY
/|/ OF SUCH DAMAGE.
/|/ ----------------------------------------------------------------------------------
*/
//end_unprocessed_text
//nfo_preprocessor_version 0
//program_version DarkStorm v3.0.2 <Firestorm-Release v4.5.1.38838> - Revolution Perenti
//mono


key http_request_id = NULL_KEY;
string HTTP_INFO_PHP    = "index.php?option=com_breedable&view=configuration&task=configuration.Update";
string HTTP_HOSTNAME     = "http://oyobreedables.com/";
integer DEBUG           = TRUE;
string getLocation()
{
    vector pos = llGetPos();
    return llGetRegionName() + " (" + (string) llRound(pos.x) + ", " + (string) llRound(pos.y) + ", " + (string) llRound(pos.z) + ")";
}

set_name(key id, string name)
{
    string url = HTTP_HOSTNAME + HTTP_INFO_PHP;
    url += "&breedable_key=" + (string) id;
    url += "&breedable_name="             + llEscapeURL(name);
    url += "&owner_name="             + llEscapeURL(llKey2Name(llGetOwner()));
    url += "&owner_key="              + (string) llGetOwner();
    url += "&location="               + llEscapeURL(getLocation());

    
    url += "&mode="  + llEscapeURL("rename");

    
    url += "&format="  + llEscapeURL("raw");
    
    log("request: " + url + " (" + (string) llStringLength(url) + " char)");

    
    http_request_id = llHTTPRequest(url, [HTTP_METHOD, "GET"], "");
}




log(string message)
{
    if (DEBUG) llOwnerSay(message);
}



display_result(string body)
{
    
    llSay(0, body);
    
}


default
{
    touch_start(integer total_number)
    {
        
          set_name(llGetKey(),llGetObjectName());
    }

    
    http_response(key request_id, integer status, list metadata, string body)
    {
        if(http_request_id == request_id)
        {
            log("status: " + (string) status);
            if (status == 400)
                log("Bad Request");            
            if (status == 401)
                log("Unauthorized");            
            if (status == 403)
                log("Forbidden");            
            if (status == 404)
                log("Page not found");            
            else if (status == 500)
                log("Service not available");
            else if (status >= 300)
                log("Unknown error: " + (string) status);
            else
                display_result(body);            
        }
    }
}

























