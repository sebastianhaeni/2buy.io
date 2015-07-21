function merge(target, source){
  if(typeof source === 'number' || typeof source === 'string'){
    return source;
  }
  if(Array.isArray(source)){
    return target.concat(source);
  }
  var res = {}
  for(var attr in target){
    res[attr] = target[attr];
  }
  for(var attr in source){
    if(res.hasOwnProperty(attr)){
      res[attr] = merge(target[attr], source[attr]);
    } else {
      res[attr] = source[attr];
    }
  }

  return res;
}

module.exports = merge;
