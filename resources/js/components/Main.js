import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Switch} from 'react-router-dom';
import Header from './common/Header';
import Home from './pages/Index';
import About from './pages/About';
import Blog from './pages/News';
import NewsDetails from './pages/NewsDetails'

class App extends Component {
    render() {
        return (
            <BrowserRouter>
                <div>
                    <Header />
                    <Switch>
                        <Route exact path='/' component={Home}/>
                        <Route path='/about' component={About}/>
                        <Route exact path='/blog' component={Blog}/>
                        <Route exact path="/blog/:id" component={NewsDetails} />
                    </Switch>
                </div>
            </BrowserRouter>
        )
    }
}

ReactDOM.render(<App />, document.getElementById('app'))