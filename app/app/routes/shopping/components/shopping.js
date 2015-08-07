import React from 'react';
import { DocumentTitle } from '_lib/components';

const style = {};

style.addArticle = {
  position: 'absolute',
  right: 20
};

export default React.createClass({

  componentDidMount() {
    // enable mdl behavior
    componentHandler.upgradeDom();
  },

  render() {
    return (
      <DocumentTitle title="Shopping List">
        <div className="mdl-grid">
          <button
            id="add-shopping-article"
            className="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab mdl-button--colored"
            onClick={this._handleAddArticle}
            style={style.addArticle}>
            <i className="material-icons">add</i>
          </button>
          <div className="mdl-tooltip" htmlFor="add-shopping-article">Add shopping list article</div>
        </div>
      </DocumentTitle>
    );
  },

  _handleAddArticle() {
    console.log('adding article');
  }

});
