import React from 'react'
import {Link} from 'react-router-dom'
import logo from '../../../../public/assets/images/laravel.png'

const Header = () => (
    <div>
        <section className="topbar">
            <div className="container">
                <div className="row">
                    <p><i className="fa fa-phone"></i> 88 01851334234 || Email : <i className="fa fa-envelope"></i>
                        info@w3xplorers.com</p>
                </div>
            </div>
        </section>
        <section className="logo_bar">
            <div className="container">
                <div className="row">
                    <a href="" className="site-logo"><img src={logo} alt="logo" width="200px"/></a>
                    <div className="header-info">
                        <div className="hf-item">
                            <i className="fa fa-clock-o"></i>
                            <p><span>Working Days:</span>Saturday - Thursday: 08 AM - 4.00 PM</p>
                        </div>
                        <div className="hf-item">
                            <i className="fa fa-map-marker"></i>
                            <p><span>Location : </span> Didar Market, Chittagong</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <nav className="nav-section">
            <div className="container">
                <div className="row">
                    <div id='cssmenu'>
                        <ul>
                            <li className='active'><Link className='navbar-brand' to='/'>Home</Link></li>
                            <li><Link className='navbar-brand' to='/about'>About</Link></li>
                            <li><Link className='navbar-brand' to='/blog'>Blog</Link></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
)

export default Header