package ru.er_log.utils;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.Arrays;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

public class JSONUtils {
    
    private final File file;
    private JSONObject jsonObj = null;
    
    public JSONUtils(String path, String name)
    {
        file = new File(path, name);
        create();
    }
    
    public void setPropertyToArray(String key, Object[] values)
    {
        jsonObj = loadConfig();
        
        JSONArray array = new JSONArray();
        if (jsonObj.containsKey(key)) array = (JSONArray) jsonObj.get(key);
        
        array.addAll(Arrays.asList(values));
        setProperty(key, array);
    }
    
    public void deletePropertyFromArray(String key, Object value)
    {
        jsonObj = loadConfig();
        
        JSONArray array = null;
        if (jsonObj.containsKey(key)) array = (JSONArray) jsonObj.get(key);
        
        if (array != null)
        {
            for (int i = 0; i < array.size(); i++)
            {
                if (array.get(i) != null && array.get(i).toString().contains(value.toString()))
                    array.remove(array.get(i));
            }
            
            setProperty(key, array);
        }
    }
    
    public Object[] getPropertyArray(String key)
    {
        jsonObj = loadConfig();
        Object obj = jsonObj.get(key);
        if (obj != null) return ((JSONArray) obj).toArray();
        
        return new Object[] {};
    }
    
    public void setProperty(String key, Object value)
    {
        jsonObj = loadConfig();
        jsonObj.put(key, value);
        write();
    }
    
    public void deleteProperty(String key)
    {
        if (jsonObj.containsKey(key)) jsonObj.remove(key);
    }
    
    public String getPropertyString(String key)
    {
        jsonObj = loadConfig();
        Object obj = jsonObj.get(key);
        if (obj != null) return obj.toString();
        
        return null;
    }
    
    public boolean getPropertyBoolean(String key)
    {
        jsonObj = loadConfig();
        Object obj = jsonObj.get(key);
        if (obj != null) return Boolean.valueOf(obj.toString());
        
        return false;
    }
    
    public int getPropertyInt(String key)
    {
        jsonObj = loadConfig();
        Object obj = jsonObj.get(key);
        if (obj != null) return new Integer(obj.toString());
        
        return 0;
    }
    
    private JSONObject loadConfig()
    {
        create();
        
        try
        {
            JSONParser parser = new JSONParser();
            String json = BaseUtils.readFromFile(file);
            if (json == null) return null;
            
            return (JSONObject) parser.parse(json);
        } catch (ParseException e) {}
        
        return new JSONObject();
    }
    
    private void create()
    {
        try
        {
            if (!file.exists()) file.createNewFile();
        } catch (IOException e) {}
    }
    
    private void write()
    {
        if (jsonObj != null)
        {
            BaseUtils.writeToFile(file, jsonObj.toJSONString());
        }
    }
}
