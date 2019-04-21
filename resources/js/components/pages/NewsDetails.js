import React, {Component} from 'react'
import axios from 'axios'

class NewsDetails extends Component {
    constructor(props) {
        super(props)
        this.state = {
            news: []
        }
    }

    componentDidMount() {
        console.log(this.props);
        this.fetchPostDetails();
    }



    fetchPostDetails() {

        axios.get("/api/blog/" + this.props.match.params.id).then(response => {
            this.setState({
                news: response.data.result
            })
        })

    }


    render() {
        const {news} = this.state

        return (
            <div className="container m-top-60">
                <div className="row">
                    <div className="col-md-12 col-sm-12 blog-page-section">
                        <div className="post-item post-details">
                            <img src={'../' + news.file_path} className="post-thumb-full img-responsive"
                                 alt={news.title}/>
                            <div className="post-content">
                                <h3>{news.title}</h3>
                                <div className="post-meta">
                                    <span><i className="fa fa-calendar-o"></i> {news.created_at}</span>
                                </div>
                                <p className="news_details"> {news.description}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default NewsDetails;