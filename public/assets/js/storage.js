function ModelBase(data)
{
	this.storage = 'friday';
}

ModelBase.prototype._construct = function(data)
{
  if ( ! data)
    return;
  for(field in data)
    if(field in this)
      this[field] = data[field];
}

ModelBase.prototype.getStorage = function(key)
{
  return this.storage + '_' + key;
}

ModelBase.prototype.set = function(key, value)
{
  key = this.getStorage(key);
  localStorage.setItem(key, value);
}

ModelBase.prototype.get = function(key)
{
  key = this.getStorage(key);
  return localStorage.getItem(key);
}

ModelBase.prototype.remove = function(key)
{
  key = this.getStorage(key);
  localStorage.removeItem(key);
}

local_storage = new ModelBase();