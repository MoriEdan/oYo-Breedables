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

string UNNAMED_BREEDABLE = "Reserved Birth";

string getLocation()
{
    vector pos = llGetPos();
    return llGetRegionName() + " (" + (string) llRound(pos.x) + ", " + (string) llRound(pos.y) + ", " + (string) llRound(pos.z) + ")";
}

log(string message)
{
    if (DEBUG) llOwnerSay(message);
}

set_location(integer id)
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
set_name(integer id, string name)
{
    string url = HTTP_HOSTNAME + HTTP_INFO_PHP;
    url += "&id=" + (string) id;
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
/|/ usage example
/|/id^breedable_dob^breedable_gender^breedable_coat^breedable_eyes^breedable_food^breedable_health^breedable_fevor^breedable_walk^breedable_range^breedable_terrain^breedable_sound^breedable_title^breedable_pregnant^breedable_mane^breedable_mate^breedable_name^breedable_key^generation^owner_name^owner_key^location^status^version
setup_breedable(string command)
{
    list values = llParseString2List(command,["^"],[]);
    string url = HTTP_HOSTNAME + HTTP_INFO_PHP;
    url += "&id="               + llEscapeURL(llList2String(values,0));
    url += "&breedable_dob="               + llEscapeURL(llList2String(values,1));
    url += "&breedable_gender="               + llEscapeURL(llList2String(values,2));
    url += "&breedable_coat="               + llEscapeURL(llList2String(values,3));
    url += "&breedable_eyes="               + llEscapeURL(llList2String(values,4));
    url += "&breedable_food="               + llEscapeURL(llList2String(values,5));
    url += "&breedable_health="               + llEscapeURL(llList2String(values,6));
    url += "&breedable_fevor="               + llEscapeURL(llList2String(values,7));
    url += "&breedable_walk="               + llEscapeURL(llList2String(values,8));
    url += "&breedable_range="               + llEscapeURL(llList2String(values,9));
    url += "&breedable_terrain="               + llEscapeURL(llList2String(values,10));
    url += "&breedable_sound="               + llEscapeURL(llList2String(values,11));
    url += "&breedable_title="               + llEscapeURL(llList2String(values,12));
    url += "&breedable_pregnant="               + llEscapeURL(llList2String(values,13));
    url += "&breedable_mane="               + llEscapeURL(llList2String(values,14));
    url += "&breedable_mate="               + llEscapeURL(llList2String(values,15));
    url += "&breedable_name="               + llEscapeURL(llList2String(values,16));
    url += "&breedable_key="               + llEscapeURL(llList2String(values,17));
    url += "&generation="               + llEscapeURL(llList2String(values,18));
    url += "&owner_name="               + llEscapeURL(llList2String(values,19));
    url += "&owner_key="               + llEscapeURL(llList2String(values,20));
    url += "&location="               + llEscapeURL(llList2String(values,21));
    url += "&mode="               + llEscapeURL("setup");
    url += "&status="               + llEscapeURL(llList2String(values,22));
    url += "&version="               + llEscapeURL(llList2String(values,23));
}

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
          set_name(10,llGetObjectName());
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

set_name(integer id, string name)
{
    string url = HTTP_HOSTNAME + HTTP_INFO_PHP;
    url += "&id=" + (string) id;
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
        
          set_name(10,llGetObjectName());
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

























