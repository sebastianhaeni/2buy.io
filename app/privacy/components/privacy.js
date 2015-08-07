import React from 'react';
import { Navigation } from 'react-router';
import { DocumentTitle, Footer } from '_lib/components';

export default React.createClass({

  mixins: [ Navigation ],

  render() {
    const layoutStyle = {
      backgroundColor: '#444'
    };

    const cardStyle = {
      width: '100%'
    };

    return (
      <DocumentTitle title="Privacy and Terms">
        <div className="mdl-layout mdl-js-layout" style={layoutStyle}>
          <header className="mdl-layout__header mdl-layout__header--transparent">
            <div className="mdl-layout__drawer-button" onClick={this.goBack}>
              <i className="material-icons">arrow_back</i>
            </div>
            <div className="mdl-layout__header-row">
              <span className="mdl-layout-title">Privacy and Terms</span>
            </div>
          </header>
          <main className="mdl-layout__content">
            <div className="mdl-grid">
              <div className="mdl-cell mdl-cell--12-col">
                <div className="mdl-card mdl-shadow--2dp" style={cardStyle}>
                  <div className="mdl-card__supporting-text">
                    <h2>Section 1</h2>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc elementum risus enim, non dapibus
                      mi blandit quis. Etiam iaculis, augue id hendrerit accumsan, ipsum lectus interdum nunc, a
                      ullamcorper diam mauris ut sem. Nullam ut odio vulputate, pellentesque urna molestie, ultricies
                      tortor. Quisque dapibus efficitur purus. Donec molestie tristique mi sed egestas. Aenean efficitur
                      lacinia erat nec tincidunt. Vivamus mauris orci, blandit sit amet posuere ac, tempor ut nisi.
                      Etiam tristique, purus ac pharetra gravida, libero ante varius urna, commodo rhoncus turpis leo at
                      libero. Morbi at ipsum sit amet velit pellentesque consequat malesuada et quam. In iaculis gravida
                      tempus.
                    </p>
                    <h2>Section 2</h2>
                    <p>
                      Duis quis lorem sed quam tristique porta sed nec libero. Etiam interdum venenatis lorem, ac
                      tempor arcu congue at. Vestibulum efficitur arcu enim, eu dignissim lacus tempus interdum. Aenean
                      suscipit lectus ut scelerisque dapibus. Donec eros leo, sollicitudin ut eros id, convallis dictum
                      nulla. Morbi est massa, lacinia eu pharetra eu, laoreet sit amet dolor. Praesent placerat arcu sit
                      amet velit porttitor, et sollicitudin urna accumsan. Etiam bibendum egestas elementum. Praesent
                      fermentum malesuada tincidunt. Etiam vel leo dui. Suspendisse molestie ante id ligula ultrices
                      rutrum. Nulla sed metus nisl. Nam consectetur gravida augue et facilisis.
                    </p>
                    <h2>Section 3</h2>
                    <p>
                      Praesent eget gravida lectus. In placerat, dui ut convallis cursus, ligula ligula vestibulum
                      metus, porttitor egestas nisi diam vel lacus. Vestibulum euismod porttitor tempor. Quisque pretium
                      dignissim porttitor. Vivamus ac placerat nibh, in blandit massa. Etiam mollis vitae odio et
                      condimentum. Mauris eu sapien urna. Ut non tempor urna. Nullam posuere semper lacus, a suscipit
                      massa placerat luctus. Sed at condimentum tortor, eu pellentesque lectus. Integer iaculis libero
                      lectus, sed eleifend enim aliquam ac.
                    </p>
                    <h2>Section 4</h2>
                    <p>
                      Maecenas venenatis ac tortor in fringilla. Nulla facilisi. Proin ornare turpis vel interdum
                      consectetur. Maecenas sit amet condimentum lorem. Ut ut ligula erat. Nulla a est non urna rutrum
                      aliquam sit amet ut leo. Vestibulum fermentum aliquet facilisis. Proin nibh felis, fringilla eget
                      magna sed, sodales aliquam eros. Phasellus mollis, sem tincidunt luctus efficitur, felis leo
                      congue ante, quis mattis leo erat quis dui. Sed non dui sed risus fringilla aliquam. Aenean
                      placerat posuere justo, eget sagittis urna luctus eget. Integer pulvinar eros nec ex consectetur
                      tempor. Vivamus vehicula, dui sed congue porttitor, orci tortor finibus leo, ornare ultrices
                      tortor eros et velit. Suspendisse potenti. Aenean feugiat mattis purus, sit amet convallis sem.
                      Etiam urna enim, tincidunt eget est eget, efficitur ultrices libero.
                    </p>
                    <h2>Section 5</h2>
                    <p>
                      Etiam ultricies ligula sit amet mauris pretium imperdiet. Nulla libero neque, luctus rhoncus lorem
                      at, vehicula venenatis lacus. Cras consectetur lorem risus, quis finibus diam feugiat hendrerit.
                      Aliquam eleifend fermentum est et euismod. Lorem ipsum dolor sit amet, consectetur adipiscing
                      elit. Aliquam eu elementum eros. Suspendisse viverra facilisis lorem, vitae tristique nulla congue
                      a.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </main>
          <Footer/>
        </div>
      </DocumentTitle>
    );
  }

});
