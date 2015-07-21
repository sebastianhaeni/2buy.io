import React from 'react';
import { AppCanvas, Styles } from 'material-ui';
import Home from '../routes/Home/components/Home';
import Footer from './Footer';

const ThemeManager = new Styles.ThemeManager();

export default React.createClass({

  propTypes: {
    children: React.PropTypes.object
  },

  childContextTypes: {
    muiTheme: React.PropTypes.object
  },

  getChildContext() {
    return {
      muiTheme: ThemeManager.getCurrentTheme()
    };
  },

  componentWillMount() {
    ThemeManager.getCurrentTheme().setPalette({
      primary1Color: Styles.Colors.lightBlue600
    });
  },

  render() {
    return (
      <AppCanvas>
        {this.props.children || <Home />}
        <Footer />
      </AppCanvas>
    );
  }
});
