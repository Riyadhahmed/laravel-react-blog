import React from 'react'
import BlogWidget from '../common/BlogWidget'

import SideImage from '../../../../public/assets/images/BG_image_8.png'

const Home = () => {
    return (
        <div className="container m-top-60">
            <div className="row">
                <div className="col-md-8 col-sm-12 post-list">
                    <div className="post-item">
                        <div className="post-content">
                            <h4>Welcome To Laravel React Blog</h4>
                            <hr/>
                            <p className="justify">
                                <img src={SideImage} className="img-thumbnail" width="300" alt=""/>
                                The necessity of quality education for the underprivileged children of Chittagong Hill
                                Tracts was felt for a long time. With the splendid aim of preparing the next generation
                                of this region as responsible and educated citizens of the country the General Officer
                                Commanding of 24 Infantry Division and Area Commander of Chittagong area laid the
                                foundation stone of Khagrachari Cantonment Public School & College (KCPSC) on April 27,
                                2002. The institution was formally inaugurated on December 28, 2005 by Chief of Army
                                Staff Lt Gen Moyeen U Ahmed. Maj Asif Iqbal, AEC was the first Principal of the
                                Institution.
                                KCPSC is located right beside Khagrachari Cantonment in an area of 9.42 acre of land
                                surrounded by pictorial / charming green hills. The structural design of the modern
                                state of art buildings of the institution greatly charms visitors. On the north side of
                                the campus there is a hillside lake with a sculpture of white lotus symbolizing beauty
                                and unity of multicultural communities of Khagrachari.

                                The hostel of the institution was built with a view to imparting education to the
                                students living in remote places of the Chittagong Hill Tracts. The hostel life is a
                                perfect example of the cultural and ethnic diversity of this region. The four storied
                                hostel building has a capacity of 100 students.

                                We have a plan to start Language Club, Debate Club, Music & Dance Club to explore and
                                nourish the hidden potentiality of the young learners. The motto of the institution is
                                to impart education, discipline and morality. It has a flag of navy blue colour with the
                                monogram of the institution in the middle...
                                <a href="" className="text-green"> Read More</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div className="col-sm-12 col-md-4 sidebar">
                    <div className="widget">
                        <h4 className="widget-title">Notice Board</h4>
                        <hr/>
                        <div className="recent-post-widget">
                            <BlogWidget category="Latest News" limit="5" layout="list"/>
                        </div>
                    </div>
                </div>
            </div>
            <section className="blog-section spad">
                <div className="row">
                    <div className="col-md-12 col-sm-12 section-title text-center">
                        <h3>LATEST NEWS</h3>
                        <p>Get latest breaking news & top stories today</p>
                    </div>
                    <div className="col-md-12 col-sm-12">
                        <BlogWidget category="Latest News" limit="4" layout="grid"/>
                    </div>
                </div>
            </section>
        </div>
    )
}

export default Home