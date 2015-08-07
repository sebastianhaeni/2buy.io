import React from 'react';
import createSideEffect from 'react-side-effect';

function getTitleFromPropsList(propsList) {
  let innermostProps = propsList[propsList.length - 1];
  if (innermostProps) {
    return innermostProps.title;
  }
}

export default createSideEffect((propsList) => {
  let title = getTitleFromPropsList(propsList) || '2buy.io';

  if (typeof document !== 'undefined') {
    document.title = title;
  }

  Array.from(document.getElementsByClassName('document-title')).forEach((t) => {
    t.textContent = title;
  });
}, {
  displayName: 'DocumentTitle',

  propTypes: {
    title: React.PropTypes.string.isRequired
  }
});
