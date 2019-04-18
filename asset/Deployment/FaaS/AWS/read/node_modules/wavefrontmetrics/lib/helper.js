'use strict';

function tagger(tags, globaltags) {
  // return tags in the format 'env="prod" service="qa"'
  // Also merges the global tags with metric tags
  let mergedTags = Object.assign({}, tags, globaltags);
  return Object.keys(mergedTags).map(
    key => `${key}="${escapeQuotes(mergedTags[key])}"`).join(' ');
}

function escapeQuotes(str) {
  return str.replace(/\"/g, "\\\"");
}

function isEmpty(value) {
  return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
}

module.exports = {
  tagger,
  escapeQuotes,
  isEmpty
};
